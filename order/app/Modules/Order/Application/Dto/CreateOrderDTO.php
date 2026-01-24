<?php

namespace App\Modules\Order\Application\Dto;

class CreateOrderDTO
{
    public function __construct(
        public readonly string $email,
        // public readonly string $deliveryMethod,
        // public readonly array $address
    ) {}
}
