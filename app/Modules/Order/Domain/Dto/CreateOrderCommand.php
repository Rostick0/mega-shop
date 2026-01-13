<?php

namespace App\Modules\Order\Application\UseCase\CheckoutCart;

class CreateOrderCommand
{
    public function __construct(
        public readonly string $cartId,
        public readonly string $deliveryMethod,
        public readonly array $address
    ) {}
}
