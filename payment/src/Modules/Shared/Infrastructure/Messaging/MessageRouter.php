<?php

namespace Src\Modules\Shared\Infrastructure\Messaging;

use Src\Modules\Shared\Application\Port\MessageHandlerInterface;

final class MessageRouter
{
    /** @param MessageHandlerInterface[] $handlers */
    public function __construct(private readonly array $handlers) {}

    public function route(string $routingKey, array $payload): void
    {
        foreach ($this->handlers as $handler) {
            if ($handler->supports($routingKey)) {
                $handler->execute($payload);
                return;
            }
        }

        throw new \RuntimeException("No handler found for routing key: {$routingKey}");
    }
}
