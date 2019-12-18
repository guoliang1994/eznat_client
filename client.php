<?php
require __DIR__ . "/vendor/autoload.php";

use core\classes\Client;
use conf\Conf;
global $conf;

$conf = (new Conf())->conf;

# 因为windows不支持信号，所以使用定时器写文件来判断是否正在运行。
# linux 直接定时任务运行这个文件就行，因为不会重复启动多个
if (DIRECTORY_SEPARATOR == '\\') {
    $time = file_get_contents('isRunning');
    if (time() - $time <= $conf['keep_alive']) {
       die('The client is already running');
    }
}

$client = new Client();
$client::runAll();



