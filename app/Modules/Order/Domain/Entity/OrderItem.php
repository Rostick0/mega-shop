<?php

namespace App\Modules\Order\Domain\Entity;

class OrderItem
{
    public function __construct(
        public readonly int $id,
        public readonly int $order_id,
        public readonly int $product_id,
        public readonly int $price_snapshot,
        public readonly string $title_snapshot,
        public readonly int $quantity,
        public readonly int $total,
    ) {}
}
