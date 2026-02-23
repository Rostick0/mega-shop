<?php

namespace App\Modules\Payment\Application\Dto;

use App\Modules\Payment\Domain\ValueObject\CurrencyEnum;

class CreatePaymentDTO
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly string $external_reference,
        public readonly string $provider,
        // public readonly ?int $provider_payment_id = null,
        public readonly int $amount,
        public readonly CurrencyEnum $currency,
        // public readonly PaymentStatusEnum $status,
        // public readonly \DateTimeImmutable $created_at,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            external_reference: $data['external_reference'],
            provider: $data['provider'],
            amount: $data['amount'],
            currency: CurrencyEnum::from($data['currency']),
        );
    }
}
