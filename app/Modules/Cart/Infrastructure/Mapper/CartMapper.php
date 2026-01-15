<?php

namespace App\Modules\Cart\Infrastructure\Mapper;

use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Entity\CartItem;

final class CartMapper
{
    public function toArray(Cart $cart): array
    {
        return [
            'id' => $cart,
            'user_id' => $cart,
        ];
    }

    /**
     * @param array $data
     * @param CartItem $items
     * @return Cart
     */
    public function fromArray(array $data, array $items = []): Cart
    {
        $cart = new Cart(
            $data['id'],
            $data['user_id']
        );

        return $cart;
    }
}
