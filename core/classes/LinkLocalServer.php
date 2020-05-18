<?php

namespace core\classes;


use Channel\Client as ChannelClient;
use core\interfaces\ConnectionInterface;
use Workerman\Connection\AsyncTcpConnection;

class LinkLocalServer extends AsyncTcpConnection implements ConnectionInterface
{
    private $dataBus;
    private $channel;
    public function __construct($remote_address, $context_option = null)
    {
        foreach (['onConnect', 'onMessage', 'onClose', 'onError', 'onBufferFull', 'onBufferDrain'] as $event) {
            if (method_exists($this, $event)) {
                $this->$event = [$this, $event];
            }
        }
        parent::__construct($remote_address, $context_option);
    }
    public function initChannel($dataBus, $channel)
    {
       $this->dataBus = $dataBus;
       $this->channel = $channel;
       return $this;
    }
    function onMessage($connection, $data)
    {
        $send['channel'] = $this->channel;
        $send['data'] = $data;
        ChannelClient::publish("EV_IN_MSG" . $this->dataBus, $send);
    }

    function onConnect($connection)
    {
        $connection->maxSendBufferSize =  50 * 1024 *1024;
        self::$connections[$this->channel] = $connection;
        echo "\r\n连接本地服务成功";
    }

    function onClose($connection)
    {
        ChannelClient::publish("EV_IN_CLOSE" . $this->dataBus, $this->channel);
        echo "\r\n断开本地服务连接";
    }

    function onError($connection, $code, $msg)
    {
        // TODO: Implement onError() method.
    }

    function onBufferFull($connection)
    {
        // TODO: Implement onBufferFull() method.
    }

    function onBufferDrain($connection)
    {
        // TODO: Implement onBufferDrain() method.
    }
}