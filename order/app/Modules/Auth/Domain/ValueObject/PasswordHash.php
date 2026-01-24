<?php

namespace App\Modules\Auth\Domain\ValueObject;

class PasswordHash
{
    private function __construct(
        private string $value
    ) {}

    public static function fromHash(string $hash): self
    {
        return new self($hash);
    }

    public function value(): string
    {
        return $this->value;
    }
}
