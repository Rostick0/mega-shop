<?php

namespace App\Modules\Order\Infrastructure\Persistence;

use App\Modules\Order\Domain\Entity\Order;
use App\Modules\Order\Domain\Repositories\OrderRepositoryInterface;
use App\Modules\Order\Infrastructure\Eloquent\OrderModel;

// use App\Modules\Product\Application\Queries\GetProductPagination\PaginationRequest;
// use App\Modules\Product\Application\Queries\GetProductPagination\ProductSearchRequest;
// use App\Modules\Product\Domain\Dto\GetProductResponse;
// use App\Modules\Product\Domain\Dto\ProductPaginationResult;
// use App\Modules\Product\Domain\Entity\Product;
// use App\Modules\Product\Domain\Repositories\ProductRepositoryInterface;
// use App\Modules\Product\Infrastructure\Eloquent\ProductModel;
// use Illuminate\Database\Eloquent\Builder;

class EloquentOrderRepository implements OrderRepositoryInterface
{
    //  public function getById(int $id): ?Order;
    // public function store(Order $order): Order;
    // public function index()
    // {


    //     $paginate = $query->paginate(page: floor($paginationRequest->offset / $paginationRequest->limit) + 1);

    //     /** @var GetProductResponse[] $items  */
    //     $items = $paginate->map(fn($item) => new GetProductResponse(
    //         id: $item->id,
    //         title: $item->title,
    //         price: $item->price,
    //         rating: $item->rating,
    //     ))
    //         ->all();

    //     return new ProductPaginationResult(
    //         data: $items,
    //         total: $paginate->total(),
    //         current_page: $paginate->currentPage(),
    //         last_page: $paginate->lastPage(),
    //     );
    // }

    public function store(Order $order): Order
    {
        $orderModel  = OrderModel::create([
            'title' => $order->title,
            'user_id' => $order->user_id,
            'email' => $order->email,
            'amount' => $order->amount,
            'status' => $order->status,
        ]);

        $orderModel->orderItems()->createMany(array_map(
            fn($el) => [
                'product_id' => $el->product_id,
                'price_snapshot' => $el->price_snapshot,
                'title_snapshot' => $el->title_snapshot,
                'quantity' => $el->quantity,
            ],
            $order->items
        ));

        return new Order(
            id: $orderModel->id,
            title: $orderModel->title,
            user_id: $orderModel->user_id,
            email: $orderModel->email,
            amount: $orderModel->amount,
            status: $orderModel->status,
            items: $orderModel->orderItems(),
        );
    }
}
