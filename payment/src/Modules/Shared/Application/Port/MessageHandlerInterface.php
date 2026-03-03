<?php

namespace App\Modules\Shared\Application\Port;

interface MessageHandlerInterface
{
    public function execute(array $payload): void;
    public function supports(string $routingKey): bool;
}
