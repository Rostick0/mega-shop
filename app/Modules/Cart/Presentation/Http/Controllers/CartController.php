<?php

namespace App\Modules\Cart\Presentation\Http\Controllers;

use App\Modules\Cart\Application\GetActiveForUser\GetCartForUserHandler;
use Illuminate\Http\JsonResponse;

class CartController
{
    public function index(GetCartForUserHandler $handler): JsonResponse
    {
        $response = $handler->handle();

        return new JsonResponse($response);
    }
}
