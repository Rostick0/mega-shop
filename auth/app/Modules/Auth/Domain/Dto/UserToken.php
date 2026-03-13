<?php

namespace App\Modules\Auth\Domain\Dto;

final class UserToken
{
    public function __construct(
        public readonly int $userId,
        public readonly string $email,
    ) {}
}
