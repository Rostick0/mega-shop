<?php

namespace App\Modules\Payment\Application\UseCase\CreatePayment;

use App\Modules\Payment\Application\Contracts\TransactionInterface;
use App\Modules\Payment\Application\Dto\CreatePaymentDTO;
use App\Modules\Payment\Domain\Entity\Payment;
use App\Modules\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\Modules\Payment\Domain\ValueObject\PaymentStatusEnum;
use Symfony\Component\Uid\Uuid;

class CreatePaymentHandler
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
        private TransactionInterface $transaction,
    ) {}

    public function execute(CreatePaymentDTO $command): Payment
    {
        return $this->transaction->run(function () use ($command): Payment {
            $payment = new Payment(
                id: Uuid::v7()->toRfc4122(),
                external_reference: $command->external_reference,
                provider: $command->provider,
                provider_payment_id: null,
                amount: $command->amount,
                currency: $command->currency,
                status: PaymentStatusEnum::PENDING,
                created_at: new \DateTimeImmutable(),
            );

            $this->paymentRepository->store($payment);

            return $payment;
        });
    }
}
