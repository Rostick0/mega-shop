<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Cart;

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
     * @param \Cart\GetCartRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCart(\Cart\GetCartRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/cart.CartService/GetCart',
        $argument,
        ['\Cart\CartResponse', 'decode'],
        $metadata, $options);
    }

}
