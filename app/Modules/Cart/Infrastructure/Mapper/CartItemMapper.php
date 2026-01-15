<?php

namespace App\Modules\Cart\Infrastructure\Mapper;

use App\Modules\Cart\Domain\Entity\Cart;

final class CartItemMapper
{
    public function toArray(Cart $cart): array
    {
        return [
            'items' => array_map(fn($item) => [
                'product_id' => $item->product_id,
                'title_snapshot' => $item->title_snapshot,
                'price_snapshot' => $item->price_snapshot,
                'quantity' => $item->quantity,
            ], $cart->items()),
        ];
    }

    public function fromArray(Cart $cart, array $items): array
    {
        foreach ($items as $item) {
            $cart->addItem(
                $item['product_id'],
                $item['title_snapshot'],
                $item['price_snapshot'],
                $item['quantity']
            );
        }

        return $cart->items();
    }
}
