<?php

namespace App\Modules\Cart\Presentation\Http\Controllers;

use App\Modules\Cart\Application\Queries\GetActiveForUser\GetCartForUserHandler;
use App\Modules\Cart\Infrastructure\Adapter\CartOwnerResolver;
use App\Modules\Cart\Presentation\Http\Resources\CartResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController
{
    public function index(Request $request, GetCartForUserHandler $handler, CartOwnerResolver $resolver): JsonResponse
    {
        $resource = $handler->handle(
            $resolver->resolve($request->user()?->id ?? null, 1 ?? $request->session()->getId())
        );

        return new JsonResponse([
            'data' => new CartResource($resource)
        ]);
    }
}
