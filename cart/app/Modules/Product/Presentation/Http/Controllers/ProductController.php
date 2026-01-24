<?php

namespace App\Modules\Product\Presentation\Http\Controllers;

use App\Modules\Product\Application\Queries\GetProduct\GetProductHandler;
use App\Modules\Product\Application\Queries\GetProduct\GetProductQuery;
use App\Modules\Product\Application\Queries\GetProductPagination\GetProductListHandler;
use App\Modules\Product\Application\Queries\GetProductPagination\GetProductListQuery;
use App\Modules\Product\Application\Queries\GetProductPagination\PaginationRequest;
use App\Modules\Product\Application\Queries\GetProductPagination\ProductSearchRequest;
use App\Modules\Product\Presentation\Http\Requests\GetProductListRequest;
use Illuminate\Http\JsonResponse;

class ProductController
{
    public function index(GetProductListRequest $request, GetProductListHandler $handler): JsonResponse
    {
        $limit =  $request->validated('limit', 20);

        $paginationRequest = new PaginationRequest(
            limit: $limit,
            offset: ((int)$request->validated('page', 1) - 1) * $limit
        );

        $productSearchRequest = new ProductSearchRequest(
            title: $request->validated('title'),
            priceFrom: $request->validated('price_from'),
            priceTo: $request->validated('price_to')
        );

        $response = $handler->handle(
            new GetProductListQuery(
                $paginationRequest,
                $productSearchRequest
            )
        );

        return new JsonResponse($response);
    }

    public function show(int $id, GetProductHandler $handler): JsonResponse
    {
        $response = $handler->handle(
            new GetProductQuery($id)
        );

        if (!$response) {
            abort(404);
        }

        return new JsonResponse([
            'data' => $response
        ]);
    }
}
