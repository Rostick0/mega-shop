<?php

namespace App\Modules\Cart\Infrastructure\Repository;

use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Entity\CartItem;
use App\Modules\Cart\Domain\Repositories\CartRepositoryInterface;
use App\Modules\Cart\Domain\ValueObject\CartOwner\CartOwner;
use App\Modules\Cart\Infrastructure\Mapper\CartMapper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class CacheCartRepository implements CartRepositoryInterface
{
    public function __construct(
        public CartMapper $cartMapper,
    ) {}


    public function getActive(CartOwner $cartOwner): Cart
    {
        $cartOwnerVal = $cartOwner->__toString();

        $keyCart = "cart:{$cartOwnerVal}";

        $cart = Cache::get($keyCart);

        if (!$cart) {
            throw new \Exception('Cart is empty'); 
        }

        $data = json_decode($cart, true);

        $cartArray = [
            ...$data,
            'owner' => $cartOwner,
        ];

        return $this->cartMapper->fromArray($cartArray);
    }

    public function store(Cart $cart): Cart
    {
        $cartOwnerVal = $cart->getOwner()->__toString();
        $keyCart = "cart:{$cartOwnerVal}";

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
            json_encode($this->cartMapper->toArray($cart),),
            60 * 60 * 24
        );

        return $cart;
    }
}
