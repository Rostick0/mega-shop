<?php

namespace App\Modules\Product\Application\Queries\GetProductPagination;

class ProductSearchRequest
{
    public function __construct(
        public ?string $title = null,
        public ?float $priceFrom = null,
        public ?float $priceTo = null,
    ) {}
}
