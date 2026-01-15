<?php

namespace App\Modules\Cart\Infrastructure\Adapter;

use App\Modules\Cart\Domain\ValueObject\CartOwner\CartOwner;
use App\Modules\Cart\Domain\ValueObject\CartOwner\SessionOwner;
use App\Modules\Cart\Domain\ValueObject\CartOwner\UserOwner;
use Illuminate\Http\Request;

class CartOwnerResolver
{
    public function resolve(Request $request): CartOwner
    {
        if ($userId = $request->user()?->id) {
            return new UserOwner($userId);
        }

        return new SessionOwner(
            $request->session()->getId()
        );
    }
}
