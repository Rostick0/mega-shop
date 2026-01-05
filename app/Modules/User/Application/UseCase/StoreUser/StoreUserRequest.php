<?php

namespace App\Modules\User\Application\UseCase\StoreUser;

use App\Modules\User\Domain\ValueObject\PasswordHash;

class StoreUserRequest
{
    public function __construct(
        public ?string $name,
        public string $email,
        public string $password,
    ) {}
}
