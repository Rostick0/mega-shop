<?php
// GENERATED CODE -- DO NOT EDIT!

namespace App\Grpc\Cart;

/**
 */
class CartServiceClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \App\Grpc\Cart\GetCartRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCart(\App\Grpc\Cart\GetCartRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/cart.CartService/GetCart',
        $argument,
        ['\App\Grpc\Cart\CartResponse', 'decode'],
        $metadata, $options);
    }

}
