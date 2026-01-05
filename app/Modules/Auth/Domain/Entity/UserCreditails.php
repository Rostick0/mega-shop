<?php

namespace App\Modules\User\Domain\Entity;

use App\Modules\Auth\Domain\ValueObject\PasswordHash;

class UserCreditails
{
    public function __construct(
        public readonly string $email,
        public readonly PasswordHash $password,
    ) {}
}
