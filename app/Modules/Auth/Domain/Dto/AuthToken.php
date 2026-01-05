<?php

namespace App\Modules\Auth\Domain\Dto;

use App\Modules\User\Domain\Entity\User;

class AuthToken
{
    public function __construct(
        public string $token,
        public User $user
    ) {}
}
