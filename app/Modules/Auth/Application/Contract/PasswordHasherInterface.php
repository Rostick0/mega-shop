<?php

namespace App\Modules\Auth\Domain\Entity;

interface PasswordHasherInterface
{
    public function hash(string $plain): string;
    public function verify(string $plain, string $hash): bool;
}
