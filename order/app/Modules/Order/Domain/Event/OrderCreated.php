<?php

namespace App\Modules\Order\Domain\Event;

use App\Modules\Order\Domain\Entity\OrderStatusEnum;

class OrderCreated
{

    public function __construct(
        public readonly int $id,
        public readonly ?int $user_id = null,
        public readonly string $email,
        public readonly string $provider,
        public readonly float $amount,
        public readonly OrderStatusEnum $status,
    ) {}
}
