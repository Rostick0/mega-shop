<?php

namespace App\Modules\Auth\Domain\Entity;

class RefreshToken
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly string $jti,
        public readonly int $user_id,
        public readonly \DateTimeImmutable $expires_at,
        public readonly ?\DateTimeImmutable $revoked_at = null,
    ) {}

    public function isExpired(\DateTimeImmutable $date): bool
    {
        return $this->expires_at < $date;
    }


    public function isRevoked(): bool
    {
        return $this->revoked_at !== null;
    }
}
