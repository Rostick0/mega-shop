<?php

namespace App\Modules\User\Application\UseCase\DeleteUser;

class DeleteUserQuery
{
    public function __construct(
        public int $userId
    ) {}
}
