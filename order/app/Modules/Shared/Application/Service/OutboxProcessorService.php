<?php

namespace App\Modules\Shared\Application\Service;

use App\Modules\Shared\Application\Port\MessagePublisherInterface;
use App\Modules\Shared\Application\Port\OutboxRepositoryInterface;
use App\Modules\Shared\Domain\Entity\OutboxMessage;

class OutboxProcessorService
{
    public function __construct(
        private readonly OutboxRepositoryInterface $outboxRepository,
        private readonly MessagePublisherInterface $publisher,
    ) {}

    public function process(): void
    {
        $messages = $this->outboxRepository->findPending(limit: 10);

        foreach ($messages as $message) {
            $this->processMessage($message);
        }
    }

    private function processMessage(OutboxMessage $message): void
    {
        try {
            $this->outboxRepository->markAsProcessing($message->id);

            $this->publisher->publish(
                exchange: $message->exchange,
                routingKey: $message->routingKey,
                payload: $message->payload,
            );

            $this->outboxRepository->markAsSent($message->id);
        } catch (\Exception $e) {
            $this->outboxRepository->markAsFailed(
                id: $message->id,
                error: $e->getMessage(),
                isFinal: $message->attempts >= 3,
            );
        }
    }
}
