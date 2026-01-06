<?php

namespace App\Modules\Auth\Domain\Dto;


class RefreshToken
{
    public function __construct(
        public string $token,
        public \DateTimeImmutable $time,
    ) {}
}
