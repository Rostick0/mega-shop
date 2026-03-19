<?php

namespace App\Modules\Shared\Domain\Entity;

final class OutboxMessage
{
    public function __construct(
        public readonly string $id,
        public readonly string $exchange,
        public readonly string $routingKey,
        public readonly array  $payload,
        public readonly int    $attempts = 0,
    ) {}
}
