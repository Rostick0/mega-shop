<?php

namespace App\Modules\Auth\Domain\Dto;

class AccessAndRefreshTokens
{
    public function __construct(
        public readonly AccessToken $accessToken,
        public readonly RefreshToken $refreshToken,
    ) {}
}
