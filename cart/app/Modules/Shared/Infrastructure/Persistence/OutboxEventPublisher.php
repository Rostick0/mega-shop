<?php

namespace App\Modules\Shared\Infrastructure\Persistence;

use App\Modules\Shared\Application\Port\EventPublisherInterface;
use App\Modules\Shared\Infrastructure\Eloquent\EloquentOutboxMessage;
use Illuminate\Support\Str;

class OutboxEventPublisher implements EventPublisherInterface
{
    public function publish(object $event, string $exchange, string $routingKey): void
    {
        // Сохраняем в outbox — всегда внутри текущей транзакции
        EloquentOutboxMessage::create([
            'id'          => Str::uuid(),
            'exchange'    => $exchange,
            'routing_key' => $routingKey,
            'payload'     => json_encode($event),
            'status'      => 'pending',
            'created_at'  => now(),
        ]);
    }
}
