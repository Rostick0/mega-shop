<?php

namespace App\Modules\Order\Presentation\Http\Resources;

use App\Modules\Order\Domain\Entity\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Order $order */
        $order = $this->resource;

        $items = [];
        foreach ($order->getItems() as $item) {
            $items[] = [
                'order_id' => $item->order_id,
                'product_id' => $item->product_id,
                'title_snapshot' => $item->title_snapshot,
                'price_snapshot' => $item->price_snapshot,
                'quantity' => $item->quantity,
            ];
        }

        return [
            'id' => $order->id,
            'title' => $order->title,
            'email' => $order->email,
            'amount' => $order->amount,
            'status' => $order->status,
            'items' => $items,
        ];
    }
}
