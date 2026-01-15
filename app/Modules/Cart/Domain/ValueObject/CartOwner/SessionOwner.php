<?php

namespace App\Modules\Cart\Domain\ValueObject\CartOwner;

final class SessionOwner implements CartOwner
{
    public function __construct(private string $sessionId) {}

    public function value(): string
    {
        return $this->sessionId;
    }

    public function type(): string
    {
        return 'session';
    }
}
