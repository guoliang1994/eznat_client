<?php
require __DIR__ . "/vendor/autoload.php";

use core\classes\Client;
use conf\Conf;

global $conf;
global $registerKey; // 请求上线返回的key

$conf = parse_ini_file('conf/conf.ini');

const EV_OUT_CONNECT = 1;
const EV_OUT_MSG = 2;
const EV_OUT_CLOSE = 3;
const EV_IN_CONNECT = 4;
const EV_IN_MSG = 5;
const EV_IN_CLOSE = 6;
const EV_IN_APPLY_LINK_KEY = 7;
const EV_CHANNEL_CLIENT_IS_ONLINE = 8; # 客户端已经在线
const EV_CHANNEL_LINK_KEY = 9;

# 因为windows不支持信号，所以使用定时器写文件来判断是否正在运行。
# linux 直接定时任务运行这个文件就行，因为不会重复启动多个
if (DIRECTORY_SEPARATOR == '\\') {
    $time = file_get_contents('isRunning');
    if (time() - $time <= $conf['check_running_cycle']) {
        die('客户端已经启动');
    }
}

$client = new Client();
$client::runAll();


