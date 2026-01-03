<?php

namespace App\Modules\User\Application\Queries\GetUserPagination;

class UserSearchRequest
{
    public function __construct(
        public ?string $name = null,
    ) {}
}
