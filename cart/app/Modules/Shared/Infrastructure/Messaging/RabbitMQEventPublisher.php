<?php

namespace App\Modules\Shared\Infrastructure\Messaging;

use App\Modules\Shared\Application\Port\MessagePublisherInterface;
use Illuminate\Support\Str;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

final class RabbitMQEventPublisher implements MessagePublisherInterface
{
    private ?AMQPStreamConnection $connection = null;

    public function publish(string $exchange, string $routingKey, array $payload): void
    {
        $channel = $this->getConnection()->channel();

        $message = new AMQPMessage(
            body: json_encode($payload),
            properties: [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
                'content_type'  => 'application/json',
                'message_id'    => (string) Str::uuid(),
            ]
        );

        $channel->confirm_select();
        $channel->basic_publish($message, $exchange, $routingKey);
        $channel->wait_for_pending_acks(5);
    }

    private function getConnection(): AMQPStreamConnection
    {
        if (!$this->connection || !$this->connection->isConnected()) {
            $this->connection = new AMQPStreamConnection(
                host: config('rabbitmq.hosts.0.host'),
                port: config('rabbitmq.hosts.0.port'),
                user: config('rabbitmq.hosts.0.user'),
                password: config('rabbitmq.hosts.0.password'),
                vhost: config('rabbitmq.hosts.0.vhost'),
            );
        }

        return $this->connection;
    }
}
