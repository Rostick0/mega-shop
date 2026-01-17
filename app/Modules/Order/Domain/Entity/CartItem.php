<?php

namespace App\Modules\Cart\Domain\Entity;

class CartItem
{
    public function __construct(
        public readonly int $cart_id,
        public readonly int $product_id,
        public readonly string $title_snapshot,
        public readonly string $price_snapshot,
        public readonly int $quantity,
    ) {}

    public function setQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new \Exception('Quantity must be positive');
        }

        $this->quantity = $quantity;
    }
}
