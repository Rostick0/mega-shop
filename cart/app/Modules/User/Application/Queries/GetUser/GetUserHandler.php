<?php

namespace App\Modules\User\Application\Queries\GetUser;

use App\Modules\User\Domain\Dto\GetUserResponse;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;

class GetUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function handle(GetUserQuery $query): ?GetUserResponse
    {
        $user = $this->repository->getById($query->userId);

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
