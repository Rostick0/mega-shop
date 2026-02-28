<?php

namespace App\Modules\Shared\Application\Port;

interface OutboxRepositoryInterface
{
    public function findPending(int $limit): array;
    public function markAsProcessing(string $id): void;
    public function markAsSent(string $id): void;
    public function markAsFailed(string $id, string $error, bool $isFinal): void;
}
