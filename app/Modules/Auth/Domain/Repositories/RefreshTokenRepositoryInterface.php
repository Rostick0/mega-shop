<?php

namespace App\Modules\Auth\Domain\Repositories;

use App\Modules\Auth\Application\UseCase\StoreRefreshToken\StoreRefreshTokenRequest;
use App\Modules\Auth\Domain\Entity\RefreshToken;

interface RefreshTokenRepositoryInterface
{
    public function store(StoreRefreshTokenRequest $jti): RefreshToken;
    public function getByJti(string $jti): RefreshToken;
    public function revoke(string $jti): bool;
}
