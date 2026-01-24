<?php

namespace App\Modules\Auth\Application\Contract;

interface PasswordHasherInterface
{
    public function hash(string $plain): string;
    public function verify(string $plain, string $hash): bool;
}
