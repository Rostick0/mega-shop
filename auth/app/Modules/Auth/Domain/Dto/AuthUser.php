<?php

namespace App\Modules\Auth\Domain\Dto;

use App\Modules\Auth\Domain\Entity\UserCreditails;
use App\Modules\User\Domain\Dto\GetUserResponse;

class AuthUser
{
    public function __construct(
        public readonly UserCreditails $credentials,
        public readonly GetUserResponse $user,
    ) {}
}
