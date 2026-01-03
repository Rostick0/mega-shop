<?php

namespace App\Modules\User\Domain\Repositories;

use App\Modules\User\Application\Queries\GetUserPagination\PaginationRequest;
use App\Modules\User\Application\Queries\GetUserPagination\UserSearchRequest;
use App\Modules\User\Application\UseCase\UpdateUser\UpdateUserRequest;
use App\Modules\User\Domain\Dto\UserPaginationResult;
use App\Modules\User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function paginate(PaginationRequest $paginationRequest, UserSearchRequest $productSearchRequest): UserPaginationResult;
    public function getById(int $id): ?User;
    public function updateById(int $id, UpdateUserRequest $request): ?User;
    public function deleteById(int $id): bool;
}
