<?php

namespace App\Modules\Auth\Application\Contract;

use App\Modules\Auth\Domain\Dto\AccessAndRefreshTokens;
use App\Modules\Auth\Domain\Dto\AccessToken;
use App\Modules\Auth\Domain\Dto\RefreshToken;
use App\Modules\Auth\Domain\Dto\RefreshTokenPayload;
use App\Modules\Auth\Domain\Dto\TokenPayload;


interface TokenServiceInterface
{
    public function issueAccessToken(int $userId): AccessToken;
    public function issueRefreshToken(int $userId): RefreshToken;
    public function parseAccessToken(string $token): TokenPayload;
    public function parseRefreshToken(string $token): RefreshTokenPayload;
    public function refresh(string $refreshToken): AccessAndRefreshTokens;
}
