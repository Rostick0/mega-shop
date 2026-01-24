<?php

namespace App\Modules\Product\Domain\Dto;

class ProductPaginationResult
{
    /**
     * @param GetProductResponse[] $data
     */
    public function __construct(
        public array $data,
        public int $total,
        public int $current_page,
        public int $last_page,
    ) {}
}
