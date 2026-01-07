<?php

namespace App\Modules\Auth\Domain\Dto;

final class TokenPayload
{
    public function __construct(
        public readonly int $userId,
    ) {}
}
