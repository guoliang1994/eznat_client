<?php
namespace conf;

class Conf
{
    public  $conf = [
        'channel_port' => '9918', # 通道的端口号
        'channel_ip' => 'aa.bb.com', # 通道服务器ip地址
        'channel' => '41105316ccklklj84deggdgfdsdfe9519d2d1', # 通道，服务端web界面获取
        'keep_alive' => 4 # 客户端重启心跳时间，单位s
    ];
}