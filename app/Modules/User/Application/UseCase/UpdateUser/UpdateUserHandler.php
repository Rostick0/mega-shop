<?php

namespace App\Modules\User\Application\UseCase\UpdateUser;

use App\Modules\User\Application\UseCase\UpdateUser\UpdateUserQuery;
use App\Modules\User\Domain\Dto\GetUserResponse;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;

class UpdateUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function handle(UpdateUserQuery $query): ?GetUserResponse
    {
        $user = $this->repository->updateById($query->userId, $query->updateUserRequest);

        if (!$user) {
            return null;
        }

        return new GetUserResponse(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            email_verified_at: $user->email_verified_at,
        );
    }
}
