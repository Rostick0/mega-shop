<?php

namespace App\Broker\Rabbitmq;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;

class Connection
{
    private static ?AMQPStreamConnection $connection = null;
    private static ?AMQPChannel $channel = null;

    public static function getChannel(): AMQPChannel
    {
        if (!self::$connection || !self::$connection->isConnected()) {
            self::$connection = new AMQPStreamConnection(
                host: config('rabbitmq.hosts.0.host'),
                port: config('rabbitmq.hosts.0.port'),
                user: config('rabbitmq.hosts.0.user'),
                password: config('rabbitmq.hosts.0.password'),
                vhost: config('rabbitmq.hosts.0.vhost'),
                heartbeat: 60,        // держит соединение живым
                connection_timeout: 10,
                read_write_timeout: 10,
            );
        }

        if (!self::$channel || !self::$channel->is_open()) {
            self::$channel = self::$connection->channel();
        }

        return self::$channel;
    }

    public static function close(): void
    {
        self::$channel?->close();
        self::$connection?->close();
    }
}
