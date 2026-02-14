<?php

namespace App\Modules\User\Application\UseCase\StoreRefreshToken;

use App\Modules\Auth\Domain\Dto\GetRefreshTokenResponse;
use App\Modules\Auth\Domain\Entity\RefreshToken;
use App\Modules\Auth\Domain\Repositories\RefreshTokenRepositoryInterface;

class StoreRefreshTokenHandler
{
    public function __construct(
        private RefreshTokenRepositoryInterface $repository
    ) {}

    public function handle(RefreshToken $request): GetRefreshTokenResponse
    {
        $refreshToken = $this->repository->store($request);

        return new GetRefreshTokenResponse(
            id: $refreshToken->id,
            jti: $refreshToken->jti,
            user_id: $refreshToken->user_id,
            expires_at: $refreshToken->expires_at,
            revoked_at: $refreshToken->revoked_at,
        );
    }
}
