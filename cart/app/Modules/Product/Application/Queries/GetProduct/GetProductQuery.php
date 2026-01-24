<?php

namespace App\Modules\Product\Application\Queries\GetProduct;

class GetProductQuery
{
    public function __construct(
        public int $productId
    ) {}
}
