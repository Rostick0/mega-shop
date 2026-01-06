<?php

namespace App\Modules\Auth\Domain\Dto;


class AccessToken
{
    public function __construct(
        public string $token,
        public \DateTimeImmutable $time,
    ) {}
}
