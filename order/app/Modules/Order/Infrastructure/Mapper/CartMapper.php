<?php

namespace App\Modules\Order\Infrastructure\Mapper;

use App\Modules\Order\Domain\Entity\Cart;

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
            items: $data['items'] ?? [],
        );

        return $cart;
    }
}
