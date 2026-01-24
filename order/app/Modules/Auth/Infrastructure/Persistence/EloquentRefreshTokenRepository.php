<?php

namespace App\Modules\Auth\Infrastructure\Persistence;

use App\Modules\Auth\Application\UseCase\StoreRefreshToken\StoreRefreshTokenRequest;
use App\Modules\Auth\Domain\Entity\RefreshToken;
use App\Modules\Auth\Domain\Repositories\RefreshTokenRepositoryInterface;
use App\Modules\Auth\Infrastructure\Eloquent\RefreshTokenModel;

class EloquentRefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public function store(StoreRefreshTokenRequest $request): RefreshToken
    {
        $refreshToken = RefreshTokenModel::create([
            'jti' => $request->jti,
            'user_id' => $request->user_id,
            'expires_at' => $request->expires_at,
        ]);

        return new  RefreshToken(
            id: $refreshToken->id,
            jti: $refreshToken->jti,
            user_id: $refreshToken->user_id,
            expires_at: $refreshToken->expires_at,
            revoked_at: $refreshToken->revoked_at,
        );
    }

    public function getByJti(string $jti): RefreshToken
    {
        $refreshToken = RefreshTokenModel::where('jti', $jti)->first();

        return new RefreshToken(
            id: $refreshToken->id,
            jti: $refreshToken->jti,
            user_id: $refreshToken->user_id,
            expires_at: new \DateTimeImmutable($refreshToken->expires_at),
            revoked_at: $refreshToken->revoked_at ? new \DateTimeImmutable($refreshToken->revoked_at) : null,
        );
    }

    public function revoke(string $jti): bool
    {
        return RefreshTokenModel::where('jti', $jti)
            ->update([
                'revoked_at' => now()
            ]);
    }
}
