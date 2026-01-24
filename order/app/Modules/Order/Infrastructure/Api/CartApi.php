<?php

namespace App\Modules\Order\Infrastructure\Api;

use App\Modules\Order\Domain\Api\CartApiInterface;
use App\Modules\Order\Domain\Entity\Cart;
use Illuminate\Http\Client\Factory as HttpFactory;
use App\Modules\Order\Infrastructure\Mapper\CartMapper;

class CartApi implements CartApiInterface
{
    public function __construct(
        public HttpFactory $http,
        public CartMapper $cartMapper,
    ) {}

    public function get(): Cart
    {
        $res = $this->http->get(url()->asset('/api/carts'));

        if ($res->successful()) {
            $data = $res->json();

            return $this->cartMapper->fromArray($data['data']);
        }

        throw new \Exception('');
    }
}
