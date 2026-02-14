<?php

namespace App\Modules\Auth\Domain\Dto;

final class RefreshTokenPayload
{
    public function __construct(
        public readonly int $userId,
        public readonly string $jti,
    ) {}
}
