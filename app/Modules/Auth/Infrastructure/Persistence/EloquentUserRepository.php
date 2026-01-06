<?php

namespace App\Modules\Auth\Infrastructure\Persistence;

use App\Modules\Auth\Domain\Repositories\AuthRepositoryInterface;
use App\Modules\Auth\Domain\ValueObject\PasswordHash;
use App\Modules\User\Domain\Entity\UserCreditails;
use App\Modules\User\Infrastructure\Eloquent\UserModel;

class EloquentUserRepository implements AuthRepositoryInterface
{
    public function getByEmail(string $email): ?UserCreditails
    {
        $user = UserModel::firstWhere('email', $email);

        if (!$user) {
            return null;
        }

        return new UserCreditails(
            id: $user->id,
            email: $user->email,
            password: PasswordHash::fromHash($user->password),
        );
    }
}
