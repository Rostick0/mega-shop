<?php

namespace App\Modules\Product\Application\Queries\GetProduct;

use App\Modules\Product\Domain\Dto\GetProductResponse;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;

class GetProductHandler
{
    public function __construct(
        private ProductRepositoryInterface $repository
    ) {}

    public function handle(GetProductQuery $query): ?GetProductResponse
    {
        $product = $this->repository->getById($query->productId);

        if (!$product) {
            return null;
        }

        return new GetProductResponse(
            id: $product->id,
            title: $product->title,
            price: $product->price,
            rating: $product->rating,
        );
    }
}
