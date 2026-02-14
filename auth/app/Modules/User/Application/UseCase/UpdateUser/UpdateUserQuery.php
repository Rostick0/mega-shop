<?php

namespace App\Modules\User\Application\UseCase\UpdateUser;

use App\Modules\User\Application\UseCase\UpdateUser\UpdateUserRequest;

class UpdateUserQuery
{
    public function __construct(
        public int $userId,
        public UpdateUserRequest $updateUserRequest
    ) {}
}
