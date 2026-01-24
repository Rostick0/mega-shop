<?php

namespace App\Modules\Cart\Infrastructure\Mapper;

use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Entity\CartItem;

final class CartMapper
{
    public function toArray(Cart $cart): array
    {
        return [
            'id' => $cart->getId(),
            'owner' => $cart->getOwner(),
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
            items: $data['items'] ?? [],
        );

        return $cart;
    }
}
