<?php

namespace App\Modules\Auth\Application\Contract;

use App\Modules\Auth\Domain\Dto\AccessToken;
use App\Modules\Auth\Domain\Dto\RefreshToken;
use App\Modules\User\Domain\Dto\GetUserResponse;

class PayloadAuthRequest
{
    public function __construct(
        public AccessToken $accessToken,
        public RefreshToken $refreshToken,
        public GetUserResponse $user
    ) {}
}
