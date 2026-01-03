<?php

namespace App\Modules\User\Infrastructure\Persistence;

use App\Modules\User\Application\Queries\GetUserPagination\PaginationRequest;
use App\Modules\User\Application\Queries\GetUserPagination\UserSearchRequest;
use App\Modules\User\Application\UseCase\UpdateUser\UpdateUserRequest;
use App\Modules\User\Domain\Dto\GetUserResponse;
use App\Modules\User\Domain\Dto\UserPaginationResult;
use App\Modules\User\Domain\Entity\User;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;
use App\Modules\User\Infrastructure\Eloquent\UserModel;
use Illuminate\Database\Eloquent\Builder;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function paginate(PaginationRequest $paginationRequest, UserSearchRequest $productSearchRequest): UserPaginationResult
    {
        $query = UserModel::query()
            ->when(
                $productSearchRequest->name,
                function (Builder $query, string $name) {
                    $query->where('name', 'LIKE', "%{$name}%");
                }
            );

        $paginate = $query->paginate(page: floor($paginationRequest->offset / $paginationRequest->limit) + 1);

        /** @var GetUserResponse[] $items  */
        $items = $paginate->map(fn($item) => new GetUserResponse(
            id: $item->id,
            name: $item->name,
            email: $item->email,
            email_verified_at: $item->email_verified_at,
        ))
            ->all();

        return new UserPaginationResult(
            data: $items,
            total: $paginate->total(),
            current_page: $paginate->currentPage(),
            last_page: $paginate->lastPage(),
        );
    }

    public function getById(int $id): ?User
    {
        $user = UserModel::find($id);

        if (!$user) {
            return null;
        }

        return new User(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            email_verified_at: $user->email_verified_at,
        );
    }

    public function updateById(int $id, UpdateUserRequest $values): ?User
    {
        $user = UserModel::find($id);

        if (!$user) {
            return null;
        }

        if ($values->name) {
            $user->name = $values->name;
        }

        return new User(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            email_verified_at: $user->email_verified_at,
        );
    }

    public function deleteById(int $id): bool
    {
        $user = UserModel::destroy($id);

        return (bool) $user;
    }
}
