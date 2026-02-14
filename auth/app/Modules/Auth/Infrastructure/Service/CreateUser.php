<?php

namespace App\Modules\Auth\Infrastructure\Service;

use App\Modules\Auth\Application\Contract\PasswordHasherInterface;
use App\Modules\Auth\Domain\ValueObject\PasswordHash;
use App\Modules\Auth\Presentation\Http\Requests\RegisgerAuthFormRequest;
use App\Modules\User\Application\UseCase\StoreUser\StoreUserHandler;
use App\Modules\User\Application\UseCase\StoreUser\StoreUserRequest;
use App\Modules\User\Domain\Dto\GetUserResponse;

final readonly class CreateUser
{
    public function __construct(
        private PasswordHasherInterface $passwordHasher,
        private StoreUserHandler $handler
    ) {}

    public function handle(RegisgerAuthFormRequest $formRequest): GetUserResponse
    {
        $hash = $this->passwordHasher->hash($formRequest->input('password'));

        return $this->handler->handle(
            new StoreUserRequest(
                name: $formRequest->input('name'),
                email: $formRequest->input('email'),
                password: PasswordHash::fromHash($hash),
            )
        );
    }
}
