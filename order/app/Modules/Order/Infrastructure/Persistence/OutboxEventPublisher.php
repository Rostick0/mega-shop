<?php

namespace App\Modules\Order\Infrastructure\Messaging;

use App\Modules\Order\Application\Port\EventPublisherInterface;
use App\Modules\Order\Infrastructure\Eloquent\EloquentOutboxMessage;

class OutboxEventPublisher implements EventPublisherInterface
{
    public function publish(object $event, string $exchange, string $routingKey): void
    {
        // Сохраняем в outbox — всегда внутри текущей транзакции
        EloquentOutboxMessage::create([
            'id'          => \Str::uuid(),
            'exchange'    => $exchange,
            'routing_key' => $routingKey,
            'payload'     => json_encode($event->toArray()),
            'status'      => 'pending',
            'created_at'  => now(),
        ]);
    }
}
