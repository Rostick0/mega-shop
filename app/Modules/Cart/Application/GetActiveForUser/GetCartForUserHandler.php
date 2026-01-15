<?php

namespace App\Modules\Cart\Application\GetActiveForUser;

use App\Modules\Auth\Application\Contract\CurrentUserProviderInterface;
use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Repositories\CartRepositoryInterface;
use App\Modules\Cart\Domain\ValueObject\CartOwner\CartOwner;

class GetCartForUserHandler
{
    public function __construct(
        private CartRepositoryInterface $repository,
    ) {}

    public function handle(CartOwner $cartOwner): Cart
    {
        $cart = $this->repository->getActive(
            $cartOwner
        );

        return $cart;
    }
}
