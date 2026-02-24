<?php

namespace App\Broker\Rabbitmq;

use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Wire\AMQPTable;

class Publisher
{
    private \PhpAmqpLib\Channel\AMQPChannel $channel;

    public function __construct()
    {
        $this->channel = Connection::getChannel();
        $this->declareInfrastructure();
    }

    private function declareInfrastructure(): void
    {
        // Dead Letter Exchange — куда идут сообщения после всех retry
        $this->channel->exchange_declare(
            exchange: 'dlx',
            type: AMQPExchangeType::DIRECT,
            durable: true,
            auto_delete: false,
        );

        // Основной exchange
        $this->channel->exchange_declare(
            exchange: 'services',
            type: AMQPExchangeType::TOPIC, // topic позволяет гибкую маршрутизацию
            durable: true,                 // переживает рестарт RabbitMQ
            auto_delete: false,
        );

        // Dead Letter Queue
        $this->channel->queue_declare(
            queue: 'dead_letter',
            durable: true,
            auto_delete: false,
        );
        $this->channel->queue_bind('dead_letter', 'dlx', '#');

        // Основная очередь с настройками retry
        $this->channel->queue_declare(
            queue: 'order_service',
            durable: true,          // переживает рестарт RabbitMQ
            auto_delete: false,
            arguments: new AMQPTable([
                'x-dead-letter-exchange'    => 'dlx',     // куда после исчерпания retry
                'x-dead-letter-routing-key' => 'failed',
                'x-message-ttl'             => 30000,     // TTL сообщения 30 сек (опционально)
            ]),
        );

        $this->channel->queue_bind('order_service', 'services', 'order.*');
    }

    public function publish(string $routingKey, array $data): void
    {
        $message = new AMQPMessage(
            body: json_encode($data),
            properties: [
                'delivery_mode'  => AMQPMessage::DELIVERY_MODE_PERSISTENT, // сохраняется на диск
                'content_type'   => 'application/json',
                'message_id'     => uniqid('msg_', true),
                'timestamp'      => time(),
                'app_id'         => config('app.name'),
            ]
        );

        // Publisher Confirms — RabbitMQ подтверждает что принял сообщение
        $this->channel->confirm_select();
        $this->channel->set_ack_handler(function (AMQPMessage $msg) {
            \Log::info('Message confirmed by RabbitMQ', ['tag' => $msg->getDeliveryTag()]);
        });
        $this->channel->set_nack_handler(function (AMQPMessage $msg) {
            \Log::error('Message rejected by RabbitMQ', ['tag' => $msg->getDeliveryTag()]);
            // здесь можно сохранить в БД для повторной отправки
        });

        $this->channel->basic_publish($message, 'services', $routingKey);
        $this->channel->wait_for_pending_acks(5); // ждём подтверждения до 5 сек
    }
}
