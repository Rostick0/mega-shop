<?php

namespace App\Modules\Order\Presentation\Http\Controllers;

use App\Broker\Rabbitmq\Publisher;
use App\Modules\Order\Application\Dto\CreateOrderDTO;
use App\Modules\Order\Application\Dto\OrderSearchCriteria;
use App\Modules\Order\Application\Dto\PaginationRequest;
use App\Modules\Order\Application\Queries\GetOrderListHandler;
use App\Modules\Order\Application\Queries\GetOrderListQuery;
use App\Modules\Order\Application\UseCase\CreateOrder\CreateOrderHandler;
use App\Modules\Order\Presentation\Http\Requests\IndexOrderRequest;
use App\Modules\Order\Presentation\Http\Requests\StoreOrderRequest;
use App\Modules\Order\Presentation\Http\Resources\OrderResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController
{
    public function index(IndexOrderRequest $request, GetOrderListHandler $handler)
    {
        $limit =  $request->input('limit', 20);

        $paginationRequest = new PaginationRequest(
            limit: $limit,
            offset: ((int)$request->validated('page', 1) - 1) * $limit
        );

        $orderSearchRequest = new OrderSearchCriteria(
            title: $request->input('title'),
            user_id: Auth::id(),

            // public readonly ?DateTimeImmutable $dateFrom = null,
            // public readonly ?DateTimeImmutable $dateTo = null,
            // public readonly ?OrderStatusEnum $status = null,
            //     priceFrom: $request->validated('price_from'),
            //     priceTo: $request->validated('price_to')
        );
        $response = $handler->execute(new GetOrderListQuery(
            $paginationRequest,
            $orderSearchRequest
        ));

        return new JsonResponse($response);
    }

    public function store(StoreOrderRequest $request, CreateOrderHandler $handler)
    {
        $resource = $handler->execute(new CreateOrderDTO(
            email: Auth::user()->email ?? $request->input('email'),
            provider: $request->input('provider')
        ));

        return new JsonResponse([
            'data' => new OrderResource($resource)
        ]);
    }
}
