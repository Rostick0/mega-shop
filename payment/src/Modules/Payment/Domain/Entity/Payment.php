<?php

namespace App\Modules\Payment\Domain\Entity;

use App\Modules\Payment\Domain\ValueObject\CurrencyEnum;
use App\Modules\Payment\Domain\ValueObject\PaymentStatusEnum;

class Payment
{
    public function __construct(
        public readonly string $id,
        public readonly ?string $external_reference = null,
        public readonly string $provider,
        public readonly ?int $provider_payment_id = null,
        public readonly int $amount,
        public readonly CurrencyEnum $currency,
        public readonly PaymentStatusEnum $status,
        public readonly \DateTimeImmutable $created_at,
    ) {}
}
