<?php

namespace App\Modules\User\Application\UseCase\DeleteUser;

use App\Modules\User\Application\UseCase\DeleteUser\DeleteUserQuery;
use App\Modules\User\Domain\Repositories\UserRepositoryInterface;

class DeleteUserHandler
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function handle(DeleteUserQuery $query): ?bool
    {
        $user = $this->repository->deleteById($query->userId);

        return $user;
    }
}
