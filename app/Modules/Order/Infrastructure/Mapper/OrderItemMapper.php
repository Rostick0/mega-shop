<?php

namespace App\Modules\Order\Infrastructure\Mapper;

use App\Modules\Order\Domain\Entity\OrderItem;

final class OrderItemMapper
{
    /**
     * @param OrderItem[] $cart
     * @return array
     */
    public function toArray(array $cartItems): array
    {
        return array_map(fn(OrderItem $item) => [
            'order_id' => $item->order_id,
            'product_id' => $item->product_id,
            'title_snapshot' => $item->title_snapshot,
            'price_snapshot' => $item->price_snapshot,
            'quantity' => $item->quantity,
        ], $cartItems);
    }

    /**
     * @param array
     * @return OrderItem[]
     */
    public function fromArray(array $items): array
    {
        return array_map(
            fn($item) => new OrderItem(
                id: $item['id'] ?? null,
                order_id: $item['order_id'],
                product_id: $item['product_id'],
                title_snapshot: $item['title_snapshot'],
                price_snapshot: $item['price_snapshot'],
                quantity: $item['quantity'],
            ),
            $items
        );
    }
}
