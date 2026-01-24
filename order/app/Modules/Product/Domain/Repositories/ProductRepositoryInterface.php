<?php

namespace App\Modules\Product\Domain\Repositories;

use App\Modules\Product\Application\Queries\GetProductPagination\PaginationRequest;
use App\Modules\Product\Application\Queries\GetProductPagination\ProductSearchRequest;
use App\Modules\Product\Domain\Dto\ProductPaginationResult;
use App\Modules\Product\Domain\Entity\Product;

interface ProductRepositoryInterface
{
    // public function getList(?string $title, int $limit, int $offset): array;
    public function paginate(PaginationRequest $paginationRequest, ProductSearchRequest $productSearchRequest): ProductPaginationResult;
    public function getById(int $id): ?Product;
}
