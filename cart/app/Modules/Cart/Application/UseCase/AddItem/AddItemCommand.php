<?php

namespace App\Modules\Cart\Application\UseCase\AddItem;

use App\Modules\Cart\Domain\ValueObject\CartOwner\CartOwner;

final class AddItemCommand
{
    public function __construct(
        public readonly CartOwner $cartOwner,
        public readonly int $productId,
        public readonly string $titleSnapshot,
        public readonly string $priceSnapshot,
        public readonly int $quantity,
    ) {}
}
