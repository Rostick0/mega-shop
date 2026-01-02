<?php

namespace App\Modules\Product\Application\Queries\GetProductPagination;

class GetProductListQuery
{
    public function __construct(
        public PaginationRequest $paginactionRequest,
        public ProductSearchRequest $productSearchRequest
    ) {}
}
