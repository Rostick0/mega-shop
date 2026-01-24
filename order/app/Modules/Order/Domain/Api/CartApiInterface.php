<?php

namespace App\Modules\Order\Domain\Api;

use App\Modules\Order\Domain\Entity\Cart;

interface CartApiInterface
{
    public function get(): Cart;
}
