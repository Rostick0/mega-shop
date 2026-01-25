<?php

namespace App\Modules\Order\Domain\Entity;

enum OrderStatusEnum: string
{
    case success = 'success';
    case pending = 'pending';
    case rejected = 'rejected';
    case canceled = 'canceled';
}
