<?php

namespace App\Modules\Product\Infrastructure\Persistence;

use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Repositories\CartRepositoryInterface;
use App\Modules\Cart\Domain\ValueObject\CartOwner\CartOwner;
use App\Modules\Cart\Infrastructure\Mapper\CartMapper;
use App\Modules\Cart\Infrastructure\Mapper\CartItemMapper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

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
        public CartMapper $cartMapper,
        public CartItemMapper $cartItemMapper,
    ) {}


    public function getActive(CartOwner $cartOwner): Cart
    {
        $cartOwnerVal = $cartOwner->value() . '.' . $cartOwner->type();

        $keyCart = "cart:{$cartOwnerVal}";
        $keyCartItems = "cart:{$cartOwnerVal}:items";

        $cart = Cache::get($keyCart);
        $cartItems = Cache::get($keyCartItems);

        return $this->cartMapper->fromArray(
            json_decode($cart),
        );
    }

    public function store(Cart $cart): Cart
    {
        $cartOwner = $cart->owner();

        $cartOwnerVal = $cartOwner->value() . '.' . $cartOwner->type();
        $keyCart = "cart:{$cartOwnerVal}";
        $keyCartItems = "cart:{$cartOwnerVal}:items";

        Cache::set(
            $keyCart,
            json_encode($this->cartMapper->toArray($cart)),
            60 * 60 * 24
        );

        Cache::set(
            $keyCartItems,
            json_encode($this->cartItemMapper->toArray($cart)),
            60 * 60 * 24
        );

        return $cart;
    }
}
