<?php

namespace App\Modules\Cart\Application\Queries\GetActiveForUser;

use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Repositories\CartRepositoryInterface;
use App\Modules\Cart\Domain\ValueObject\CartOwner\CartOwner;

class GetCartForUserHandler
{
    public function __construct(
        private CartRepositoryInterface $repository,
    ) {}

    public function execute(CartOwner $cartOwner): Cart
    {
        $cart = $this->repository->getActive(
            $cartOwner
        );

        return $cart;
    }
}
