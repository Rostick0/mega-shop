<?php

namespace App\Modules\Shared\Infrastructure\Persistence;

use App\Modules\Shared\Application\Port\OutboxRepositoryInterface;
use App\Modules\Shared\Infrastructure\Eloquent\EloquentOutboxMessage;
use App\Modules\Shared\Domain\Entity\OutboxMessage;
use Illuminate\Support\Facades\DB;

class EloquentOutboxRepository implements OutboxRepositoryInterface
{
    public function findPending(int $limit): array
    {
        return EloquentOutboxMessage::where('status', 'pending')
            ->orderBy('created_at')
            ->limit($limit)
            ->lockForUpdate()
            ->get()
            ->map(fn($record) => new OutboxMessage(
                id: $record->id,
                exchange: $record->exchange,
                routingKey: $record->routing_key,
                payload: json_decode($record->payload, true),
                attempts: $record->attempts,
            ))
            ->toArray();
    }

    public function markAsProcessing(string $id): void
    {
        EloquentOutboxMessage::where('id', $id)->update(['status' => 'processing']);
    }

    public function markAsSent(string $id): void
    {
        EloquentOutboxMessage::where('id', $id)->update([
            'status'  => 'sent',
            'sent_at' => now(),
        ]);
    }

    public function markAsFailed(string $id, string $error, bool $isFinal): void
    {
        EloquentOutboxMessage::where('id', $id)->update([
            'status'   => $isFinal ? 'failed' : 'pending',
            'attempts' => DB::raw('attempts + 1'),
            'error'    => $error,
        ]);
    }
}
