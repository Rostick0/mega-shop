<?php

namespace App\Modules\Payment\Domain\ValueObject;

enum CurrencyEnum: string
{
    case USD = 'USD';
    case EUR = 'EUR';
    case RUB = 'RUB';
}
