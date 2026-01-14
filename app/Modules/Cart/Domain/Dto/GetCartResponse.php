<?php

namespace App\Modules\Cart\Domain\Dto;

class GetCartResponse
{
    public function __construct(
        public int $id,
        public string $title,
        public int $user_id,
        public ?float $amount,
        public ?string $status,
    ) {}
}
