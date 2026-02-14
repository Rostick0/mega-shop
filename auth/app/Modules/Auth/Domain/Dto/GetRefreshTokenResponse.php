<?php

namespace App\Modules\Auth\Domain\Dto;

class GetRefreshTokenResponse
{
    public function __construct(
        public readonly int $id,
        public readonly string $jti,
        public readonly int $user_id,
        public readonly \DateTimeImmutable $expires_at,
        public readonly ?\DateTimeImmutable $revoked_at = null,
    ) {}
}
