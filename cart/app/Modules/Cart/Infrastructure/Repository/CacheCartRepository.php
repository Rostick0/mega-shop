<?php

namespace App\Modules\Cart\Infrastructure\Repository;

use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Entity\CartItem;
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
        $cartOwnerVal = $cartOwner->__toString();

        $keyCart = "cart:{$cartOwnerVal}";
        $keyCartItems = "cart:{$cartOwnerVal}:items";

         // $cart = new Cart(
        //     id: $keyCart,
        //     owner: $cartOwner,
        //     items: [new CartItem(
        //         cart_id: $keyCart,
        //         product_id: 1,
        //         title_snapshot: 'Тест',
        //         price_snapshot: 500,
        //         quantity: 3
        //     )]
        // );

        // Cache::set(
        //     $keyCart,
        //     json_encode($this->cartMapper->toArray($cart)),
        //     60 * 60 * 24
        // );

        // Cache::set(
        //     $keyCartItems,
        //     json_encode($this->cartItemMapper->toArray($cart->getItems())),
        //     60 * 60 * 24
        // );

        $cart = Cache::get($keyCart);
        $cartItems = Cache::get($keyCartItems);

        $cartArray = [
            ...json_decode($cart, true),
            'owner' => $cartOwner,
            'items' => $this->cartItemMapper->fromArray(
                json_decode($cartItems, true)
            )
        ];

        return $this->cartMapper->fromArray($cartArray);
    }

    public function store(Cart $cart): Cart
    {
        $cartOwnerVal = $cart->getOwner()->__toString();
        $keyCart = "cart:{$cartOwnerVal}";
        $keyCartItems = "cart:{$cartOwnerVal}:items";

        $cart->setId($keyCart);

        // $cart = new Cart(
        //     id: $keyCart,
        //     owner: $cartOwner,
        //     items: [new CartItem(
        //         cart_id: $keyCart,
        //         product_id: 1,
        //         title_snapshot: 'Тест',
        //         price_snapshot: 500,
        //         quantity: 3
        //     )]
        // );

        Cache::set(
            $keyCart,
            json_encode($this->cartMapper->toArray($cart)),
            60 * 60 * 24
        );

        Cache::set(
            $keyCartItems,
            json_encode($this->cartItemMapper->toArray($cart->getItems())),
            60 * 60 * 24
        );

        return $cart;
    }
}
