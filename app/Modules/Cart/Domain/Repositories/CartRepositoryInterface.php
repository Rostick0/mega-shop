<?php

namespace App\Modules\Cart\Domain\Repositories;

use App\Modules\Cart\Domain\Dto\CartPaginationResult;
use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Product\Application\Queries\GetProductPagination\PaginationRequest;
use App\Modules\Product\Application\Queries\GetProductPagination\ProductSearchRequest;

interface CartRepositoryInterface
{
    // public function getList(?string $title, int $limit, int $offset): array;
    // public function paginate(PaginationRequest $paginationRequest, ProductSearchRequest $productSearchRequest): CartPaginationResult;
    public function getActiveForUser(int $userId): Cart;
    public function store(Cart $cart): Cart;
}
