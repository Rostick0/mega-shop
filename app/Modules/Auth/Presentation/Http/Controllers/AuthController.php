<?php

namespace App\Modules\Auth\Presentation\Http\Controllers;

use App\Modules\Auth\Domain\Dto\AuthToken;
use App\Modules\Auth\Domain\Entity\PasswordHasherInterface;
use App\Modules\Auth\Domain\Entity\RegistrationUser;
use App\Modules\Auth\Domain\ValueObject\PasswordHash;
use App\Modules\Auth\Presentation\Http\Requests\RegisgerAuthFormRequest;
use App\Modules\User\Application\UseCase\StoreUser\StoreUserRequest;
use App\Modules\User\Application\UseCase\StoreUser\StoreUserHandler;
use Illuminate\Http\JsonResponse;

class AuthController
{
    public function __construct(
        private PasswordHasherInterface $passwordHasher,
    ) {}

    public function register(RegisgerAuthFormRequest $formRequest, StoreUserHandler $handler, RegistrationUser $registrationUser)
    {
        // $user = 

        $user = $registrationUser->handle($formRequest, $handler);

        $token = null;

        return new JsonResponse([
            'data' => new AuthToken(
                token: $token,
                user: $user,
            ),
        ]);
    }
}
