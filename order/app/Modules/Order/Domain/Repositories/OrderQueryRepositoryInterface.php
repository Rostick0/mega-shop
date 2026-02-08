<?php

namespace App\Modules\Order\Domain\Repositories;

use App\Modules\Order\Application\Dto\OrderPaginationResult;
use App\Modules\Order\Application\Dto\OrderSearchCriteria;
use App\Modules\Order\Application\Dto\PaginationRequest;
use App\Modules\Order\Domain\Entity\Order;

interface OrderQueryRepositoryInterface
{
    public function searchPaginated(PaginationRequest $paginationRequest, OrderSearchCriteria $orderSearchCriteria): OrderPaginationResult;
    public function findById(int $id): Order;
}
