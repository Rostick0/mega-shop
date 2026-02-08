<?php

namespace App\Modules\Order\Infrastructure\Persistence;

use App\Modules\Order\Application\Dto\GetOrderResponse;
use App\Modules\Order\Application\Dto\OrderPaginationResult;
use App\Modules\Order\Application\Dto\OrderSearchCriteria;
use App\Modules\Order\Application\Dto\PaginationRequest;
use App\Modules\Order\Domain\Entity\Order;
use App\Modules\Order\Domain\Repositories\OrderQueryRepositoryInterface;
use App\Modules\Order\Infrastructure\Eloquent\OrderModel;
use App\Modules\Order\Infrastructure\Mapper\OrderItemMapper;
use App\Modules\Order\Infrastructure\Mapper\OrderMapper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class EloquentOrderQueryRepository implements OrderQueryRepositoryInterface
{
    public function __construct(
        public OrderMapper $orderMapper,
        public OrderItemMapper $orderItemMapper
    ) {}

    public function searchPaginated(PaginationRequest $paginationRequest, OrderSearchCriteria $orderSearchCriteria): OrderPaginationResult
    {
        // $orderSearchCriteria-> 
        $query = OrderModel::query()
            ->when(
                $orderSearchCriteria->user_id,
                function (Builder $query, string $user_id) {
                    $query->where('user_id', $user_id);
                }
            )
            ->when(
                $orderSearchCriteria->status,
                function (Builder $query, string $status) {
                    $query->where('status', $status);
                }
            )
            // ->when(
            //     $orderSearchCriteria->priceFrom,
            //     function (Builder $query, string $price) {
            //         $query->where('price', '>=', $price);
            //     }
            // )
            // ->when(
            //     $orderSearchCriteria->priceTo,
            //     function (Builder $query, string $price) {
            //         $query->where('price', '<=', $price);
            //     }
            // )
        ;

        $paginate = $query->paginate(page: $paginationRequest->getPage(), perPage: $paginationRequest->limit);

        /** @var GetOrderResponse[] $items  */
        $items = $paginate->map(fn($item) => new GetOrderResponse(
            id: $item->id,
            title: $item->title,
            user_id: $item->user_id,
            amount: $item->amount,
            status: $item->status->value,
        ))
            ->all();

        return new OrderPaginationResult(
            data: $items,
            total: $paginate->total(),
            current_page: $paginate->currentPage(),
            last_page: $paginate->lastPage(),
        );
    }

    public function findById(int $id): Order
    {
        $orderModel = OrderModel::find($id);

        if (!$orderModel) {
            throw new \Exception('Order not found');
        }

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
