<?php

namespace App\Modules\Cart\Infrastructure\Mapper;

use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Entity\CartItem;

final class CartMapper
{
    public function toArray(Cart $cart): array
    {
        return [
            'id'    => $cart->getId(),
            'owner' => (string) $cart->getOwner(),
            'items' => array_map(fn(CartItem $item) => [
                'cart_id'        => $cart->getId(),
                'product_id'     => $item->product_id,
                'title_snapshot' => $item->title_snapshot,
                'price_snapshot' => $item->price_snapshot,
                'quantity'       => $item->quantity,
            ], $cart->getItems()),
        ];
    }

    /**
     * @param array $data
     * @return Cart
     */
    public function fromArray(array $data): Cart
    {
        $cart = new Cart(
            id: $data['id'],
            owner: $data['owner'],
            items: array_map(
                fn($item) => new CartItem(
                    cart_id: $data['id'],
                    product_id: $item['product_id'],
                    title_snapshot: $item['title_snapshot'],
                    price_snapshot: $item['price_snapshot'],
                    quantity: $item['quantity'],
                ),
                $data['items']
            ),
        );

        return $cart;
    }
}
