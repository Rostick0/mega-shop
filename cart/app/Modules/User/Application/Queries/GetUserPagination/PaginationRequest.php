<?php

namespace App\Modules\User\Application\Queries\GetUserPagination;

class PaginationRequest
{
    public function __construct(
        public int $limit,
        public int $offset
    ) {}
}
