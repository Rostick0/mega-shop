<?php

namespace App\Modules\Cart\Presentation\Grpc\Controllers;

use App\Grpc\Cart\CartItem;
use App\Grpc\Cart\CartResponse;
use App\Grpc\Cart\CartServiceInterface;
use App\Grpc\Cart\GetCartRequest;
use App\Modules\Cart\Domain\Repositories\CartRepositoryInterface;
use App\Modules\Cart\Infrastructure\Adapter\CartOwnerResolver;
use Spiral\RoadRunner\GRPC\ContextInterface;

class CartController implements CartServiceInterface
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private CartOwnerResolver $resolver
    ) {}

    public function GetCart(ContextInterface $ctx, GetCartRequest $request,): CartResponse
    {
        $cart = $this->cartRepository->getActive(
            $this->resolver->resolve($request->getUserId() ?? null, 1 ?? $request->getSessionId())
        );

        $carItems = [];
        foreach ($cart->getItems() as $item) {
            $cartItem = new CartItem([
                'product_id' => $item->product_id,
                'title_snapshot' => $item->title_snapshot,
                'price_snapshot' => $item->price_snapshot,
                'quantity' => $item->quantity,
            ]);

            $carItems[] = $cartItem;
        }

        $response = new CartResponse([
            'id' => $cart->getId(),
            'total' => $cart->getTotal(),
            'items' => $carItems,
        ]);

        return $response;
    }
}
