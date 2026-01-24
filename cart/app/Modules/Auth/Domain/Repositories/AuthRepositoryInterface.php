<?php

namespace App\Modules\Auth\Domain\Repositories;

use App\Modules\Auth\Domain\Dto\AuthUser;

interface AuthRepositoryInterface
{
    public function getByEmail(string $email): ?AuthUser;
}
