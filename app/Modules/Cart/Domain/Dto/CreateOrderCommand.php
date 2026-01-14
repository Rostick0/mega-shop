<?php

namespace App\Modules\Order\Domain\Dto;

class CreateOrderCommand
{
    public function __construct(
        public readonly string $cartId,
        public readonly string $deliveryMethod,
        public readonly array $address
    ) {}
}
