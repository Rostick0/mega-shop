<?php

namespace App\Modules\Order\Domain\Event;

use App\Modules\Order\Domain\Entity\OrderStatusEnum;

class OrderCreated
{

    public function __construct(
        public readonly int $id,
        public readonly int $user_id,
        public readonly string $email,
        public readonly float $amount,
        public readonly OrderStatusEnum $status,
    ) {}
}
