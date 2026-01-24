<?php

namespace App\Modules\Cart\Infrastructure\Mapper;

use App\Modules\Cart\Domain\Entity\CartItem;

final class CartItemMapper
{
    /**
     * @param CartItem[] $cartItems
     * @return array
     */
    public function toArray(array $cartItems): array
    {
        return array_map(fn($item) => [
            'cart_id' => $item->cart_id,
            'product_id' => $item->product_id,
            'title_snapshot' => $item->title_snapshot,
            'price_snapshot' => $item->price_snapshot,
            'quantity' => $item->quantity,
        ], $cartItems);
    }

    /**
     * @param array
     * @return CartItem[]
     */
    public function fromArray(array $items): array
    {
        return array_map(
            fn($item) => new CartItem(
                cart_id: $item['cart_id'],
                product_id: $item['product_id'],
                title_snapshot: $item['title_snapshot'],
                price_snapshot: $item['price_snapshot'],
                quantity: $item['quantity'],
            ),
            $items
        );
    }
}
