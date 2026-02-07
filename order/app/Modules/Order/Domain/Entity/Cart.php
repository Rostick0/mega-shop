<?php

namespace App\Modules\Order\Domain\Entity;

class Cart
{
    /**
     * @param CartItem[] $items
     */
    public function __construct(
        public readonly ?string $id = null,
        public readonly int $total,
        private array $items = [],
    ) {}

    public function addItem(
        int $product_id,
        string $title_snapshot,
        string $price_snapshot,
        int $quantity,
    ) {
        // if ($key=array_f($this->items, fn ($el) => $el->product_id === $product_id)) {
        //     array_slice($this->items, );
        // }

        $this->items[] = new CartItem(
            cart_id: $this->id,
            product_id: $product_id,
            title_snapshot: $title_snapshot,
            price_snapshot: $price_snapshot,
            quantity: $quantity
        );
        // $this->items;
    }

    /**
     * @return CartItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    public function getTotal(): float
    {
        return array_reduce($this->items, fn($counter, $el) => $counter + $el->getSubtotal(), 0.0);
    }
}
