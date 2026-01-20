<?php

namespace App\Modules\Order\Domain\Dto;

class CreateOrderDTO
{
    public function __construct(
        public readonly string $cartId,
        public readonly string $deliveryMethod,
        public readonly array $address
    ) {}
}
