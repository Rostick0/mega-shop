<?php

namespace App\Modules\Auth\Domain\Entity;

use App\Modules\Auth\Domain\ValueObject\PasswordHash;
use App\Modules\Auth\Presentation\Http\Requests\RegisgerAuthFormRequest;
use App\Modules\User\Application\UseCase\StoreUser\StoreUserHandler;
use App\Modules\User\Application\UseCase\StoreUser\StoreUserRequest;

final readonly class RegistrationUser
{
    public function __construct(
        private PasswordHasherInterface $passwordHasher,
    ) {}

    public function handle(RegisgerAuthFormRequest $formRequest, StoreUserHandler $handler)
    {
        $hash = $this->passwordHasher->hash($formRequest->input('password'));

        return $handler->handle(
            new StoreUserRequest(
                name: $formRequest->input('name'),
                email: $formRequest->input('email'),
                password: PasswordHash::fromHash($hash),
            )
        );
    }
}
