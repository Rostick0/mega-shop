<?php

namespace App\Modules\Cart\Domain\Entity;

use App\Modules\Cart\Domain\ValueObject\CartOwner\CartOwner;

class Cart
{
    /**
     * @param CartItem[] $items
     */
    public function __construct(
        private ?string $id = null,
        public readonly CartOwner $owner,
        private array $items = [],
    ) {}

    public function getId(): string|null
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

    public function getOwner(): CartOwner
    {
        return $this->owner;
    }

    public function addItem(
        int $product_id,
        string $title_snapshot,
        string $price_snapshot,
        int $quantity,
    ): void {
        foreach ($this->items as $key => $item) {
            if ($item->product_id === $product_id) {
                $this->items[$key] = $item->withQuantity($item->quantity + $quantity);
                return;
            }
        }

        $this->items[] = new CartItem(
            cart_id:        $this->id ?? '',
            product_id:     $product_id,
            title_snapshot: $title_snapshot,
            price_snapshot: $price_snapshot,
            quantity:       $quantity,
        );
    }

    /**
     * @return CartItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return array_reduce(
            $this->items,
            fn(int $previous, CartItem $current) => $previous + $current->getTotal(),
            0
        );
    }
}
