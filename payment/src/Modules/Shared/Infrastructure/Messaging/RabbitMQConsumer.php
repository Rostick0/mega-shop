<?php

namespace Src\Modules\Shared\Infrastructure\Messaging;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Wire\AMQPTable;

final class RabbitMQConsumer
{
    private ?AMQPStreamConnection $connection = null;

    public function __construct(
        private readonly MessageRouter $router,
        private readonly string        $host,
        private readonly int           $port,
        private readonly string        $user,
        private readonly string        $password,
        private readonly string        $vhost,
    ) {}

    public function consume(string $queue): void
    {
        $channel = $this->getConnection()->channel();

        $this->declareInfrastructure($channel, $queue);

        $channel->basic_qos(prefetch_size: 0, prefetch_count: 1, a_global: false);

        $channel->basic_consume(
            queue: $queue,
            consumer_tag: '',
            no_local: false,
            no_ack: false,
            exclusive: false,
            nowait: false,
            callback: function (AMQPMessage $message) {
                $this->handleMessage($message);
            }
        );

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }

    private function handleMessage(AMQPMessage $message): void
    {
        try {
            $data       = json_decode($message->getBody(), true);
            $routingKey = $message->getRoutingKey();

            $this->router->route($routingKey, $data);

            $message->ack();
        } catch (\Exception $e) {
            $this->handleFailure($message, $e);
        }
    }

    private function handleFailure(AMQPMessage $message, \Exception $e): void
    {
        $deaths = $message->get('application_headers')
            ?->getNativeData()['x-death'] ?? [];

        if (count($deaths) < 3) {
            $message->nack(requeue: true);
        } else {
            // Исчерпали попытки — уходит в Dead Letter Queue
            $message->nack(requeue: false);
        }
    }

    private function declareInfrastructure($channel, string $queue): void
    {
        // Dead Letter Exchange
        $channel->exchange_declare(
            exchange: 'dlx',
            type: AMQPExchangeType::DIRECT,
            durable: true,
            auto_delete: false,
        );

        // Dead Letter Queue
        $channel->queue_declare(
            queue: 'dead_letter',
            durable: true,
            auto_delete: false,
        );

        $channel->queue_bind('dead_letter', 'dlx', '#');

        // Основной exchange
        $channel->exchange_declare(
            exchange: 'services',
            type: AMQPExchangeType::TOPIC,
            durable: true,
            auto_delete: false,
        );

        // Основная очередь
        $channel->queue_declare(
            queue: $queue,
            durable: true,
            auto_delete: false,
            arguments: new AMQPTable([
                'x-dead-letter-exchange'    => 'dlx',
                'x-dead-letter-routing-key' => 'failed',
            ]),
        );

        $channel->queue_bind($queue, 'services', '#');
    }

    private function getConnection(): AMQPStreamConnection
    {
        if (!$this->connection || !$this->connection->isConnected()) {
            $this->connection = new AMQPStreamConnection(
                host: $this->host,
                port: $this->port,
                user: $this->user,
                password: $this->password,
                vhost: $this->vhost,
                heartbeat: 60,
            );
        }

        return $this->connection;
    }

    public function __destruct()
    {
        $this->connection?->close();
    }
}
