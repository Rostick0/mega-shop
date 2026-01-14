<?php

namespace App\Modules\Product\Infrastructure\Persistence;

use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Repositories\CartRepositoryInterface;
use App\Modules\Cart\Infrastructure\Mapper\CartMapper;
use Illuminate\Support\Facades\Cache;

// use App\Modules\Product\Application\Queries\GetProductPagination\PaginationRequest;
// use App\Modules\Product\Application\Queries\GetProductPagination\ProductSearchRequest;
// use App\Modules\Product\Domain\Dto\GetProductResponse;
// use App\Modules\Product\Domain\Dto\ProductPaginationResult;
// use App\Modules\Product\Domain\Entity\Product;
// use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;
// use App\Modules\Product\Infrastructure\Eloquent\ProductModel;
// use Illuminate\Database\Eloquent\Builder;

class CacheCartRepository implements CartRepositoryInterface
{
    public function __construct(
        public CartMapper $cartMapper
    ) {}


    public function getActiveForUser(int $userId): Cart
    {
        $keyCart = "cart:{$userId}";
        $keyCarItems = "cart:{$userId}:items";

        $cart = Cache::get($keyCart);
        $cartItems = Cache::get($keyCarItems);

        return $this->cartMapper->fromArray(
            json_decode($cart),
            json_decode($cartItems)
        );
    }

    public function store(Cart $cart): Cart
    {
        $key = "cart:{$cart->user_id}";

        Cache::set(
            $key,
            json_encode($this->cartMapper->toArray($cart)),
            60 * 60 * 24
        );

        return $cart;
    }
}
