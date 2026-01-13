<?php

namespace App\Modules\Order\Domain\Dto;

class OrderPaginationResult
{
    /**
     * @param GetOrderResponse[] $data
     */
    public function __construct(
        public array $data,
        public int $total,
        public int $current_page,
        public int $last_page,
    ) {}
}
