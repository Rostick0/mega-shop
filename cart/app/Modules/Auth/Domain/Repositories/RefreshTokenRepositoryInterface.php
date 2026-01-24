<?php

namespace App\Modules\Auth\Domain\Repositories;

use App\Modules\Auth\Domain\Entity\RefreshToken;

interface RefreshTokenRepositoryInterface
{
    public function store(RefreshToken $jti): RefreshToken;
    public function getByJti(string $jti): RefreshToken;
    public function revoke(string $jti): bool;
}
