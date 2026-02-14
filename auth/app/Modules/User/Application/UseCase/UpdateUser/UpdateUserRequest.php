<?php

namespace App\Modules\User\Application\UseCase\UpdateUser;

class UpdateUserRequest
{
    public function __construct(
        public ?string $name,
    ) {}
}
