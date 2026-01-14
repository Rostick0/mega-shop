<?php

namespace App\Modules\Cart\Domain\Dto;

class CartPaginationResult
{
    /**
     * @param GetCartResponse[] $data
     */
    public function __construct(
        public array $data,
        public int $total,
        public int $current_page,
        public int $last_page,
    ) {}
}
