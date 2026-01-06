<?php

namespace App\Modules\Auth\Application\Entity;

use App\Modules\Auth\Domain\Dto\AccessToken;
use App\Modules\Auth\Domain\Dto\RefreshToken;
use App\Modules\User\Domain\Entity\User;
use TokenPayload;

interface TokenServiceInterface
{
    public function issueAccessToken(int $userId): AccessToken;
    public function issueRefreshToken(int $userId): RefreshToken;
    public function parseAccessToken(string $token): TokenPayload;
    public function refresh(string $refreshToken): AccessToken;
}
