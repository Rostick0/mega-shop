<?php

namespace App\Modules\Cart\Application\UseCase\AddItem;

use App\Modules\Cart\Domain\Entity\Cart;
use App\Modules\Cart\Domain\Repositories\CartRepositoryInterface;

class AddItemHandler
{
    public function __construct(
        private CartRepositoryInterface $repository,
    ) {}

    public function execute(AddItemCommand $command): Cart
    {
        try {
            $cart = $this->repository->getActive($command->cartOwner);
        } catch (\Exception) {
            $cart = new Cart(id: null, owner: $command->cartOwner);
        }

        $cart->addItem(
            product_id:      $command->productId,
            title_snapshot:  $command->titleSnapshot,
            price_snapshot:  $command->priceSnapshot,
            quantity:        $command->quantity,
        );

        return $this->repository->store($cart);
    }
}
