<?php

namespace App\Modules\Order\Infrastructure\Mapper;

use App\Modules\Order\Domain\Entity\Cart;
use App\Modules\Order\Domain\Entity\CartItem;

final class CartMapper
{
    public function toArray(Cart $cart): array
    {
        return [
            'id' => $cart->id,
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
            items: array_map(fn($item) => new CartItem(
                cart_id: $item['cart_id'],
                product_id: $item['product_id'],
                title_snapshot: $item['title_snapshot'],
                price_snapshot: $item['price_snapshot'],
                quantity: $item['quantity'],
            ), $data['items'] ?? []),
        );

        return $cart;
    }
}
