<?php

namespace App\Modules\Product\Domain\Entity;

class Product
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly float $price,
        public readonly ?float $rating,
    ) {}
}
