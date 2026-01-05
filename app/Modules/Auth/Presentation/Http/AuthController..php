<?php

namespace App\Modules\Auth\Presentation\Http;

use App\Modules\User\Application\UseCase\StoreUser\StoreUserRequest;
use App\Modules\User\Application\UseCase\StoreUser\StoreUserHandler;

class AuthController
{
    public function register(StoreUserHandler $handler)
    {
        $$handler->handle();
    }
}
