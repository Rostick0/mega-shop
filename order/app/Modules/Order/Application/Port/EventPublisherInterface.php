<?php

namespace App\Modules\Order\Application\Port;

interface EventPublisherInterface
{
    public function publish(object $event, string $exchange, string $routingKey): void;
}
