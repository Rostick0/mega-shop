<?php

namespace App\Modules\Order\Domain\ValueObject\CartOwner;

final class UserOwner implements CartOwner
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
