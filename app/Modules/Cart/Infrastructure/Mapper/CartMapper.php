<?php

namespace App\Modules\Cart\Infrastructure\Mapper;

use App\Modules\Cart\Domain\Entity\Cart;

final class CartMapper
{
    public function toArray(Cart $cart): array
    {
        return [
            'id' => $cart,
            'user_id' => $cart,
            'items' => array_map(fn($item) => [
                'product_id' => $item->product_id,
                'title_snapshot' => $item->title_snapshot,
                'price_snapshot' => $item->price_snapshot,
                'quantity' => $item->quantity,
            ], $cart->items()),
        ];
    }

    public function fromArray(array $data, array $items): Cart
    {
        $cart = new Cart(
            $data['id'],
            $data['user_id']
        );

        foreach ($items as $item) {
            $cart->addItem(
                $item['product_id'],
                $item['title_snapshot'],
                $item['price_snapshot'],
                $item['quantity']
            );
        }

        return $cart;
    }
}
