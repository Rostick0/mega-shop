<?php

namespace App\Modules\Product\Application\Queries\GetProductPagination;

use App\Modules\Product\Domain\Dto\GetProductResponse;
use App\Modules\Product\Domain\Dto\ProductPaginationResult;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;

class GetProductListHandler
{
    public function __construct(
        private ProductRepositoryInterface $repository
    ) {}

    public function handle(GetProductListQuery $query): ProductPaginationResult
    {
        $products = $this->repository->paginate($query->paginactionRequest, $query->productSearchRequest);

        return $products;
    }
}
