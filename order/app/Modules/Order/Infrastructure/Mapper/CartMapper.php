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
            'total' => $cart->total,
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
            total: $data['total'],
            items: array_map(fn($item) => new CartItem(
                product_id: $item['productId'],
                title_snapshot: $item['titleSnapshot'],
                price_snapshot: $item['priceSnapshot'],
                quantity: $item['quantity'],
            ), $data['items'] ?? []),
        );

        return $cart;
    }
}
