<?php

namespace App\Modules\Auth\Application\Queries\GetUserByEmail;

use App\Modules\Auth\Domain\Dto\AuthUser;
use App\Modules\Auth\Domain\Repositories\AuthRepositoryInterface;

class GetUserByEmailHandler
{
    public function __construct(
        private AuthRepositoryInterface $repository
    ) {}

    public function handle(GetUserByEmailQuery $query): ?AuthUser
    {
        $user = $this->repository->getByEmail($query->email);

        if (!$user) {
            return null;
        }

        return $user;
    }
}
