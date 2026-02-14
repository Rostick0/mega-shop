<?php

namespace App\Modules\Auth\Application\Queries\GetUserByEmail;

class GetUserByEmailQuery
{
    public function __construct(
        public string $email
    ) {}
}
