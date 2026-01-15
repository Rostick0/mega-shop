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
        private array $items,
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

        $this->items[] = new OrderItem(
            id: null,
            order_id: $this->id,
            product_id: $product_id,
            price_snapshot: $price_snapshot,
            title_snapshot: $title_snapshot,
            quantity: $quantity,
        );
    }

    public function items(): array
    {
        return $this->items;
    }
}
