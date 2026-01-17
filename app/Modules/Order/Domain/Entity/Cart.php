<?php

namespace App\Modules\Cart\Domain\Entity;

use App\Modules\Cart\Domain\ValueObject\CartOwner\CartOwner;

class Cart
{
    /**
     * @param CartItem[] $items
     */
    public function __construct(
        public readonly ?int $id = null,
        public readonly CartOwner $owner,
        private array $items = [],
    ) {}

    public function owner(): CartOwner
    {
        return $this->owner;
    }

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
    public function items(): array
    {
        return $this->items;
    }
}
