<?php

namespace App\Modules\Order\Infrastructure\Adapter;

use App\Modules\Order\Domain\ValueObject\CartOwner\CartOwner;
use App\Modules\Order\Domain\ValueObject\CartOwner\SessionOwner;
use App\Modules\Order\Domain\ValueObject\CartOwner\UserOwner;

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
