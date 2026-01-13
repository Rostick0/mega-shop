<?php

namespace App\Modules\Order\Domain\Repositories;

use App\Modules\Order\Domain\Dto\OrderPaginationResult;
use App\Modules\Order\Domain\Entity\Order;
use App\Modules\Product\Application\Queries\GetProductPagination\PaginationRequest;
use App\Modules\Product\Application\Queries\GetProductPagination\ProductSearchRequest;

interface OrderRepositoryInterface
{
    // public function getList(?string $title, int $limit, int $offset): array;
    // public function paginate(PaginationRequest $paginationRequest, ProductSearchRequest $productSearchRequest): OrderPaginationResult;
    public function getById(int $id): ?Order;
    public function store(Order $order): Order;
}
