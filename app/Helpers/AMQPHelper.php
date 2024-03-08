<?php

namespace App\Helpers;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AMQPHelper
{
    public static function sendMessage($queue, $message, $routingKey): void
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare($queue, false, true, false, false);
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, '', $routingKey);
        $channel->close();
        $connection->close();
    }

    public static function consumeMessage()
    {

    }
}
