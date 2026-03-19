<?php

namespace App\Modules\Shared\Application\Port;

interface MessagePublisherInterface
{
    public function publish(string $exchange, string $routingKey, array $payload): void;
}
