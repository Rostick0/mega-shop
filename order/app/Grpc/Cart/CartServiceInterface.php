<?php

namespace App\Grpc\Cart;

use Spiral\RoadRunner\GRPC\ContextInterface;
use Spiral\RoadRunner\GRPC\ServiceInterface;

interface CartServiceInterface extends ServiceInterface

{
    public const NAME = 'cart.CartService';
    public function GetCart(ContextInterface $ctx, GetCartRequest $in): CartResponse;
}
