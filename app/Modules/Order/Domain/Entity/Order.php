<?php

namespace App\Modules\Order\Domain\Entity;

class Order
{
    /**
     * @param OrderItem[] $items
     */
    public function __construct(
        public readonly ?int $id = null,
        public readonly string $title,
        public readonly ?int $user_id,
        public readonly string $email,
        public readonly ?float $amount,
        public readonly ?float $status,
        public readonly array $items,
    ) {}
}
