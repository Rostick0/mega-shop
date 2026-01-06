<?php

namespace App\Modules\Auth\Domain\Repositories;

use App\Modules\User\Domain\Entity\UserCreditails;

interface AuthRepositoryInterface
{
    public function getByEmail(string $email): ?UserCreditails;
}
