<?php

namespace App\Modules\Order\Presentation\Http\Controllers;

use App\Modules\Order\Application\UseCase\CreateOrder\CreateOrderHandler;
use App\Modules\Order\Domain\Dto\CreateOrderDTO;
use App\Modules\Order\Presentation\Http\Requests\StoreOrderListRequest;
use Illuminate\Http\JsonResponse;

class OrderConroller
{
    public function store(StoreOrderListRequest $request, CreateOrderHandler $handler)
    {
        $res = $handler->handle(new CreateOrderDTO(
            email: $request->input('email')
        ));

        return new JsonResponse();
    }
}
