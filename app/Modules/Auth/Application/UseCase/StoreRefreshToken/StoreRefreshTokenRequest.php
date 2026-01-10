<?php

namespace App\Modules\Auth\Application\UseCase\StoreRefreshToken;

class StoreRefreshTokenRequest
{
    public function __construct(
        public string $jti,
        public int $user_id,
        public \DateTimeImmutable $expires_at,
        public ?\DateTimeImmutable $revoked_at = null,
    ) {}
}
