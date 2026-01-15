<?php

namespace App\Modules\Cart\Presentation\Http\Controllers;

use App\Modules\Cart\Application\GetActiveForUser\GetCartForUserHandler;
use App\Modules\Cart\Infrastructure\Adapter\CartOwnerResolver;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController
{
    public function index(Request $request, GetCartForUserHandler $handler, CartOwnerResolver $resolver): JsonResponse
    {
        $response = $handler->handle(
            $resolver->resolve($request)
        );

        return new JsonResponse($response);
    }
}
