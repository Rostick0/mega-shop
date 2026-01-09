<?php

namespace App\Modules\Auth\Application\UseCase\RefreshToken;

use App\Modules\Auth\Application\Contract\TokenServiceInterface;
use App\Modules\Auth\Domain\Dto\AccessAndRefreshTokens;

class RefreshTokenHandler
{
    public function __construct(
        private TokenServiceInterface $repository

    ) {}

    public function handle(string $refreshToken): AccessAndRefreshTokens
    {
        return $this->repository->refresh($refreshToken);
    }
}
