<?php

namespace App\Modules\Cart\Application\GetActiveForUser;

use App\Modules\Auth\Application\Contract\CurrentUserProviderInterface;
use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Repositories\CartRepositoryInterface;

class GetCartForUserHandler
{
    public function __construct(
        private CartRepositoryInterface $repository,
        private CurrentUserProviderInterface $currentUserProvider,
    ) {}

    public function handle(): Cart
    {
        $cart = $this->repository->getActiveForUser(
            $this->currentUserProvider->get()->id
        );

        return $cart;
    }
}
