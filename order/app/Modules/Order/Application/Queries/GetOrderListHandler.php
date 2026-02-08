<?php

namespace App\Modules\Order\Application\Queries;

use App\Modules\Order\Application\Dto\OrderPaginationResult;
use App\Modules\Order\Domain\Repositories\OrderQueryRepositoryInterface;

class GetOrderListHandler
{
    public function __construct(
        private OrderQueryRepositoryInterface $repository
    ) {}

    public function execute(GetOrderListQuery $query): OrderPaginationResult
    {
        $orders = $this->repository->searchPaginated($query->paginationRequest, $query->orderSearchCriteria);

        return $orders;
    }
}
