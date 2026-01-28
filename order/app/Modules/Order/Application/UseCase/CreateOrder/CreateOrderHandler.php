<?php

namespace App\Modules\Order\Application\UseCase\CreateOrder;

use App\Modules\Auth\Application\Contract\CurrentUserProviderInterface;
use App\Modules\Order\Application\Dto\CreateOrderDTO;
use App\Modules\Order\Domain\Entity\CartItem;
use App\Modules\Order\Domain\Api\CartApiInterface;
use App\Modules\Order\Domain\Entity\Order;
use App\Modules\Order\Domain\Entity\OrderStatusEnum;
use App\Modules\Order\Domain\Repositories\OrderRepositoryInterface;

class CreateOrderHandler
{
    public function __construct(
        private CartApiInterface $cartApi,
        private OrderRepositoryInterface $orderRepository,
        private CurrentUserProviderInterface $currentUserProvider,
    ) {}

    public function execute(CreateOrderDTO $command)
    {
        $cart = $this->cartApi->get();
        dd($cart);

        $order = new Order(
            id: null,
            title: "Заказ номер ",
            user_id: $this->currentUserProvider->get()->id ?? null,
            email: $command->email,
            amount: $cart->getTotal(),
            status: OrderStatusEnum::pending,
            items: [],
        );

        foreach ($cart->getItems() as $item) {
            /** @var CartItem $item */

            $order->addItem(
                product_id: $item->product_id,
                title_snapshot: $item->title_snapshot,
                price_snapshot: $item->price_snapshot,
                quantity: $item->quantity,
            );
        }

        $createdOrder = $this->orderRepository->store($order);

        return $createdOrder;
    }
}
