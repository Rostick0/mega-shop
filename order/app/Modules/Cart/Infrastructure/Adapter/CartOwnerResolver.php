<?php

namespace App\Modules\Cart\Infrastructure\Adapter;

use App\Modules\Cart\Domain\ValueObject\CartOwner\CartOwner;
use App\Modules\Cart\Domain\ValueObject\CartOwner\SessionOwner;
use App\Modules\Cart\Domain\ValueObject\CartOwner\UserOwner;

class CartOwnerResolver
{
    public function resolve(?int $userId, string $sessionId): CartOwner
    {
        if ($userId) {
            return new UserOwner($userId);
        }

        return new SessionOwner(
            $sessionId
        );
    }
}
