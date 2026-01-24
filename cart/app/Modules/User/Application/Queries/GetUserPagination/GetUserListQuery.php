<?php

namespace App\Modules\User\Application\Queries\GetUserPagination;

class GetUserListQuery
{
    public function __construct(
        public PaginationRequest $paginactionRequest,
        public UserSearchRequest $userSearchRequest
    ) {}
}
