<?php

namespace App\Modules\User\Application\Queries\GetUser;

class GetUserQuery
{
    public function __construct(
        public int $userId
    ) {}
}
