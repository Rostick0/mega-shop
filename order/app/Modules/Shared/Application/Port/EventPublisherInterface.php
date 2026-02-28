<?php

namespace App\Modules\Shared\Application\Port;

interface EventPublisherInterface
{
    public function publish(object $event, string $exchange, string $routingKey): void;
}
