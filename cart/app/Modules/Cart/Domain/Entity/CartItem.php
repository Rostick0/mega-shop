<?php

namespace App\Modules\Cart\Domain\Entity;

class CartItem
{
    public function __construct(
        public readonly string $cart_id,
        public readonly int $product_id,
        public readonly string $title_snapshot,
        public readonly string $price_snapshot,
        public readonly int $quantity,
    ) {}

    public function withQuantity(int $quantity): self
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('Quantity must be positive');
        }

        return new self(
            cart_id:        $this->cart_id,
            product_id:     $this->product_id,
            title_snapshot: $this->title_snapshot,
            price_snapshot: $this->price_snapshot,
            quantity:       $quantity,
        );
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->price_snapshot * $this->quantity;
    }
}
