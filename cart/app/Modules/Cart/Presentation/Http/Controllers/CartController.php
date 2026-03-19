<?php

namespace App\Modules\Cart\Presentation\Http\Controllers;

use App\Modules\Cart\Application\Queries\GetActiveForUser\GetCartForUserHandler;
use App\Modules\Cart\Application\UseCase\AddItem\AddItemCommand;
use App\Modules\Cart\Application\UseCase\AddItem\AddItemHandler;
use App\Modules\Cart\Infrastructure\Adapter\CartOwnerResolver;
use App\Modules\Cart\Presentation\Http\Requests\AddItemRequest;
use App\Modules\Cart\Presentation\Http\Resources\CartResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController
{
    public function __construct(
        private CartOwnerResolver $resolver,
    ) {}

    public function index(Request $request, GetCartForUserHandler $handler): JsonResponse
    {
        try {
            $resource = $handler->execute(
                $this->resolver->resolve($request->user()?->id ?? null, $request->cookie('session', ''))
            );

            return new JsonResponse([
                'data' => new CartResource($resource)
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function store(AddItemRequest $request, AddItemHandler $handler): JsonResponse
    {
        try {
            $cart = $handler->execute(
                new AddItemCommand(
                    cartOwner:     $this->resolver->resolve($request->user()?->id ?? null, $request->cookie('session', '')),
                    productId:     $request->integer('product_id'),
                    titleSnapshot: $request->string('title_snapshot'),
                    priceSnapshot: $request->string('price_snapshot'),
                    quantity:      $request->integer('quantity'),
                )
            );

            return new JsonResponse(['data' => new CartResource($cart)], 201);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }
}
