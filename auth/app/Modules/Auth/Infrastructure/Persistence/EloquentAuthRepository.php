<?php

namespace App\Modules\Auth\Infrastructure\Persistence;

use App\Modules\Auth\Domain\Dto\AuthUser;
use App\Modules\Auth\Domain\Entity\UserCreditails;
use App\Modules\Auth\Domain\Repositories\AuthRepositoryInterface;
use App\Modules\Auth\Domain\ValueObject\PasswordHash;
use App\Modules\User\Domain\Dto\GetUserResponse;
use App\Modules\User\Infrastructure\Eloquent\UserModel;

class EloquentAuthRepository implements AuthRepositoryInterface
{
    public function getByEmail(string $email): ?AuthUser
    {
        $user = UserModel::firstWhere('email', $email);

        if (!$user) {
            return null;
        }

        return new AuthUser(
            new UserCreditails(
                id: $user->id,
                email: $user->email,
                password: PasswordHash::fromHash($user->password),
            ),
            new GetUserResponse(
                id: $user->id,
                name: $user->name,
                email: $user->email,
                email_verified_at: $user->email_verified_at,
            ),
        );
    }
}
