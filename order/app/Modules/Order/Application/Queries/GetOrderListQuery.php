<?php

namespace App\Modules\Order\Application\Queries;

use App\Modules\Order\Application\Dto\OrderSearchCriteria;
use App\Modules\Order\Application\Dto\PaginationRequest;

class GetOrderListQuery
{
    public function __construct(
        public PaginationRequest $paginationRequest,
        public OrderSearchCriteria $orderSearchCriteria
    ) {}
}
