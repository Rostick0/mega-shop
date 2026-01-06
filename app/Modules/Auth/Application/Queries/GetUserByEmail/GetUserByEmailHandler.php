<?php

namespace App\Modules\Auth\Application\Queries\GetUserByEmail;

use App\Modules\Auth\Domain\Repositories\AuthRepositoryInterface;
use App\Modules\User\Domain\Dto\GetUserResponse;
use App\Modules\User\Domain\Entity\UserCreditails;

class GetUserByEmailHandler
{
    public function __construct(
        private AuthRepositoryInterface $repository
    ) {}

    public function handle(GetUserByEmailQuery $query): ?UserCreditails
    {
        $user = $this->repository->getByEmail($query->email);

        if (!$user) {
            return null;
        }

        return $user;
    }
}
