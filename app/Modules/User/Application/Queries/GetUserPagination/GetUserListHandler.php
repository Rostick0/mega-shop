<?php

namespace App\Modules\User\Application\Queries\GetUserPagination;

use App\Modules\User\Domain\Dto\UserPaginationResult;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;

class GetUserListHandler
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function handle(GetUserListQuery $query): UserPaginationResult
    {
        $users = $this->repository->paginate($query->paginactionRequest, $query->userSearchRequest);

        return $users;
    }
}
