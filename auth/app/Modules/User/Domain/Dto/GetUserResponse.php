<?php

namespace App\Modules\User\Domain\Dto;

class GetUserResponse
{
    public function __construct(
        public readonly int $id,
        public readonly ?string $name,
        public readonly string $email,
        public readonly ?string $email_verified_at,
    ) {}
}
