<?php

namespace App\Modules\Product\Domain\Dto;

class GetProductResponse
{
    public function __construct(
        public int $id,
        public string $title,
        public float $price,
        public ?float $rating,
    ) {}
}
