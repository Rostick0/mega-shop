<?php

namespace App\Modules\Cart\Domain\Entity;

class Cart
{
    /**
     * @param CartItem[] $items
     */
    public function __construct(
        public readonly ?int $id = null,
        public readonly int $user_id,
        private array $items = [],
    ) {}

    public function addItem(
        int $product_id,
        string $title_snapshot,
        string $price_snapshot,
        int $quantity,
    ) {}

    /**
     * @return CartItem[]
     */
    public function items(): array
    {
        return $this->items;
    }
}
