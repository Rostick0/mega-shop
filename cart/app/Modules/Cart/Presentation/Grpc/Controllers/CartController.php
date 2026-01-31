<?php

namespace Cart\App\Modules\Cart\Presentation\Grpc\Controllers;

use App\Modules\Cart\Domain\Repositories\CartRepositoryInterface;
use App\Modules\Cart\Infrastructure\Adapter\CartOwnerResolver;
use Cart\CartItem;
use Cart\CartResponse;
use Cart\GetCartRequest;

class CartController
{
    public function __construct(
        private CartRepositoryInterface $cartRepository
    ) {}

    public function GetCart(GetCartRequest $request, CartOwnerResolver $resolver): CartResponse
    {


        $cart = $this->cartRepository->getActive(
            $resolver->resolve($request->getUserId() ?? null, 1 ?? $request->getSessionId())
        );

        $response = new CartResponse();

        foreach ($cart->getItems() as $item) {
            $cartItem = new CartItem();
            $cartItem->setProductId($item->product_id);
            $cartItem->setTitleSnapshot($item->title_snapshot);
            $cartItem->setPriceSnapshot($item->price_snapshot);
            $cartItem->setQuantity($item->quantity);

            $response->getItems()[] = $cartItem;
        }

        // $response->setTotal($cart->getTotal());

        return $response;
    }
}
