<?php

namespace App\Modules\Order\Domain\Dto;

class GetOrderResponse
{
    public function __construct(
        public int $id,
        public string $title,
        public int $user_id,
        public ?float $amount,
        public ?string $status,
    ) {}
}
