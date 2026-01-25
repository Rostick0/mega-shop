<?php

namespace App\Modules\Order\Presentation\Http\Controllers;

use App\Modules\Order\Application\Dto\CreateOrderDTO;
use App\Modules\Order\Application\UseCase\CreateOrder\CreateOrderHandler;
use App\Modules\Order\Presentation\Http\Requests\StoreOrderListRequest;
use App\Modules\Order\Presentation\Http\Resources\OrderResource;
use Illuminate\Http\JsonResponse;

class OrderConroller
{
    public function store(StoreOrderListRequest $request, CreateOrderHandler $handler)
    {
        $resource = $handler->execute(new CreateOrderDTO(
            email: $request->input('email')
        ));

        return new JsonResponse([
            'data' => new OrderResource($resource)
        ]);
    }
}
