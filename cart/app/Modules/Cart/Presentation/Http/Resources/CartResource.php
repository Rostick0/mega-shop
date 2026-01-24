<?php

namespace App\Modules\Cart\Presentation\Http\Resources;

use App\Modules\Cart\Domain\Entity\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Cart $cart */
        $cart = $this->resource;

        $items = [];
        foreach ($cart->getItems() as $item) {
            $items[] = [
                'product_id' => $item->product_id,
                'title_snapshot' => $item->title_snapshot,
                'price_snapshot' => $item->price_snapshot,
                'quantity' => $item->quantity,
            ];
        }

        return [
            'id' => $cart->getId(),
            'owner' => $cart->getOwner()->__toString(),
            'items' => $items,
        ];
    }
}
