<?php

namespace App\Modules\Order\Domain\Api;

use App\Modules\Cart\Domain\Entity\Cart;

interface CartApiInterface
{
    public function get(): Cart;
}
