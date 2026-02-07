<?php

namespace App\Modules\Order\Infrastructure\Grpc;

use App\Grpc\Cart\CartServiceClient;
use App\Grpc\Cart\GetCartRequest;
use App\Modules\Order\Domain\Api\CartApiInterface;
use App\Modules\Order\Domain\Entity\Cart;
use Illuminate\Http\Client\Factory as HttpFactory;
use App\Modules\Order\Infrastructure\Mapper\CartMapper;

class CartGrpc implements CartApiInterface
{
    public function __construct(
        public CartMapper $cartMapper,
    ) {}
    public function get(): Cart
    {
        $r = new CartServiceClient(
            'cart-laravel.test-1:9001',
            ['credentials' => \Grpc\ChannelCredentials::createInsecure()]
        );

        $request = new GetCartRequest();
        $request->setUserId($user?->id ?? 0);
        $request->setSessionId(session()->getId());


        [$response, $status] = $r->GetCart($request)->wait();

        if ($status->code > 0) {
            throw new \Exception('Произошла ошибка');
        }

        $json = ($response->serializeToJsonString());

        $cart = json_decode($json, true);

        return $this->cartMapper->fromArray($cart);
    }
}
