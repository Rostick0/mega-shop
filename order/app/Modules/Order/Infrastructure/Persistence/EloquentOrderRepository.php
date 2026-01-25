<?php

namespace App\Modules\Order\Infrastructure\Persistence;

use App\Modules\Order\Domain\Entity\Order;
use App\Modules\Order\Domain\Repositories\OrderRepositoryInterface;
use App\Modules\Order\Infrastructure\Eloquent\OrderModel;
use App\Modules\Order\Infrastructure\Mapper\OrderItemMapper;
use App\Modules\Order\Infrastructure\Mapper\OrderMapper;
use Illuminate\Support\Facades\DB;

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
    public function __construct(
        public OrderMapper $orderMapper,
        public OrderItemMapper $orderItemMapper
    ) {}
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
        $orderModel = OrderModel::create(
            $this->orderMapper->toArray($order),
        );


        $orderModel->ordergetItems()->createMany(
            $this->orderItemMapper->toArray($order->getItems()),
        );


        return new Order(
            id: $orderModel->id,
            title: $orderModel->title,
            user_id: $orderModel->user_id,
            email: $orderModel->email,
            amount: $orderModel->amount,
            status: $orderModel->status,
            items: $this->orderItemMapper->fromArray($orderModel->ordergetItems->toArray()),
        );
    }
}
