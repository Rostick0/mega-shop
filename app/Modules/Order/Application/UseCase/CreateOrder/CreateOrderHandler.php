<?php

namespace App\Modules\Order\Application\UseCase\CreateOrder;

use App\Modules\Auth\Application\Contract\CurrentUserProviderInterface;
use App\Modules\Order\Domain\Dto\CreateOrderCommand;
use App\Modules\Order\Domain\Entity\Order;
use App\Modules\Order\Domain\Repositories\OrderRepositoryInterface;

class CreateOrderHandler
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private CurrentUserProviderInterface $currentUserProvider,
    ) {}

    public function execute(CreateOrderCommand $command)
    {
        $orderItems = [];

        

        $order = new Order(
            id: null,
            title: "Заказ номер ",
            user_id: $this->currentUserProvider->get()->id,
            amount: null,
            status: null,
            items: $orderItems,
        );

        $createdOrder = $this->orderRepository->store($order);

        return $createdOrder;
    }
}
