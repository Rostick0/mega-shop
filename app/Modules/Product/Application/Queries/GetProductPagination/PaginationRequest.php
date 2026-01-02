<?php

namespace App\Modules\Product\Application\Queries\GetProductPagination;

class PaginationRequest
{
    public function __construct(
        public int $limit,
        public int $offset
    ) {}
}
