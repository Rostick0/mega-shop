<?php

namespace App\Modules\Order\Infrastructure\Mapper;

use App\Modules\Order\Domain\Entity\Order;

final class OrderMapper
{
    public function toArray(Order $order): array
    {
        return [
            'id' => $order->id,
            'title' => $order->title,
            'user_id' => $order->user_id,
            'email' => $order->email,
            'amount' => $order->amount,
            'status' => $order->status,
        ];
    }

    public function fromArray(array $data): Order
    {
        $order = new Order(
            id: $data['id'],
            title: $data['title'],
            user_id: $data['user_id'] ?? null,
            email: $data['email'],
            amount: $data['amount'],
            status: $data['status'],
            items: [],
        );

        return $order;
    }
}
