<?php

namespace App\Modules\User\Application\UseCase\StoreUser;

use App\Modules\User\Domain\Dto\GetUserResponse;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;

class StoreUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function handle(StoreUserRequest $request): GetUserResponse
    {
        $user = $this->repository->store($request);

        return new GetUserResponse(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            email_verified_at: $user->email_verified_at,
        );
    }
}
