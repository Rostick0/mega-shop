<?php

namespace App\Modules\Product\Infrastructure\Persistence;

use App\Modules\Product\Application\Queries\GetProductPagination\PaginationRequest;
use App\Modules\Product\Application\Queries\GetProductPagination\ProductSearchRequest;
use App\Modules\Product\Domain\Dto\GetProductResponse;
use App\Modules\Product\Domain\Dto\ProductPaginationResult;
use App\Modules\Product\Domain\Entity\Product;
use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;
use App\Modules\Product\Infrastructure\Eloquent\ProductModel;
use Illuminate\Database\Eloquent\Builder;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function paginate(PaginationRequest $paginationRequest, ProductSearchRequest $productSearchRequest): ProductPaginationResult
    {
        $query = ProductModel::query()
            ->when(
                $productSearchRequest->title,
                function (Builder $query, string $title) {
                    $query->where('title', 'LIKE', "%{$title}%");
                }
            )
            ->when(
                $productSearchRequest->priceFrom,
                function (Builder $query, string $price) {
                    $query->where('price', '>=', $price);
                }
            )
            ->when(
                $productSearchRequest->priceTo,
                function (Builder $query, string $price) {
                    $query->where('price', '<=', $price);
                }
            );

        $paginate = $query->paginate(page: floor($paginationRequest->offset / $paginationRequest->limit) + 1);

        /** @var GetProductResponse[] $items  */
        $items = $paginate->map(fn($item) => new GetProductResponse(
            id: $item->id,
            title: $item->title,
            price: $item->price,
            rating: $item->rating,
        ))
            ->all();

        return new ProductPaginationResult(
            data: $items,
            total: $paginate->total(),
            current_page: $paginate->currentPage(),
            last_page: $paginate->lastPage(),
        );
    }

    public function getById(int $id): ?Product
    {
        $product = ProductModel::find($id);

        if (!$product) {
            return null;
        }

        return new Product(
            id: $product->id,
            title: $product->title,
            price: $product->price,
            rating: $product->rating,
        );
    }
}
