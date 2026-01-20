<?php

namespace App\Modules\Order\Infrastructure\Api;

use App\Modules\Order\Domain\Api\CartApiInterface;
use App\Modules\Order\Domain\Entity\Cart;
use Illuminate\Support\Facades\Http;


class CartApi implements CartApiInterface
{
    public function __construct(
        public Http $http
    ) {}

    public function get(): Cart

    {

        //    $res
        // Http
        $resp = $this->http->get('/api/carts');

        // $resp->;

        return new Cart(
            id: 1,
        );
    }
}
