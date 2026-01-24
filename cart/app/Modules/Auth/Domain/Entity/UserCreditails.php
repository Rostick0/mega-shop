<?php

namespace App\Modules\Auth\Domain\Entity;

use App\Modules\Auth\Domain\ValueObject\PasswordHash;

class UserCreditails
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
        public readonly PasswordHash $password,
    ) {}
}
