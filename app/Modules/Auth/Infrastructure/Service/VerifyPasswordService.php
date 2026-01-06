<?php

namespace App\Modules\Auth\Infrastructure\Service;

use App\Modules\Auth\Application\Entity\PasswordHasherInterface;
use App\Modules\Auth\Domain\ValueObject\PasswordHash;
use App\Modules\Auth\Presentation\Http\Requests\LoginAuthFormRequest;
use App\Modules\User\Application\UseCase\StoreUser\StoreUserHandler;

final readonly class VerifyPasswordService
{
    public function __construct(
        private PasswordHasherInterface $passwordHasher,
    ) {}

    public function handle(LoginAuthFormRequest $formRequest, string $hashedPassword): bool
    {
        return $this->passwordHasher->verify($formRequest->input('password'), $hashedPassword);
    }
}
