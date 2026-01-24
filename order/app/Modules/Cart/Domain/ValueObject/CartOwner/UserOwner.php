<?php

namespace App\Modules\Cart\Domain\ValueObject\CartOwner;

final class UserOwner extends CartOwner
{
    public function __construct(private int $userId) {}

    public function value(): string
    {
        return (string) $this->userId;
    }

    public function type(): string
    {
        return 'user';
    }
}
