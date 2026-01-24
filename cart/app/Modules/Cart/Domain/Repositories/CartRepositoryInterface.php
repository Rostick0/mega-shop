<?php

namespace App\Modules\Cart\Domain\Repositories;

use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\ValueObject\CartOwner\CartOwner;

interface CartRepositoryInterface
{
    public function getActive(CartOwner $cartOwner): Cart;
    public function store(Cart $cart): Cart;
}
