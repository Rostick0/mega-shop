<?php

namespace App\Modules\Order\Application\UseCase\OrderCreated;

use App\Modules\Payment\Application\Contracts\TransactionInterface;
use App\Modules\Payment\Domain\Entity\Payment;
use App\Modules\Payment\Domain\Repository\PaymentRepositoryInterface;
use App\Modules\Payment\Domain\ValueObject\CurrencyEnum;
use App\Modules\Payment\Domain\ValueObject\PaymentStatusEnum;
use Src\Modules\Shared\Application\Port\MessageHandlerInterface;
use Symfony\Component\Uid\Uuid;

class OrderCreatedHandler implements MessageHandlerInterface
{

    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
        private TransactionInterface $transaction,
    ) {}

    public function supports(string $routingKey): bool
    {
        return $routingKey === 'order.created';
    }

    public function execute(array $payload): void
    {   


        $this->transaction->run(function () use ($payload): Payment {
            $payment = new Payment(
                id: Uuid::v7()->toRfc4122(),
                order_id: $payload['id'],
                provider: $payload['provider'],
                provider_payment_id: null,
                amount: $payload['amount'],
                currency: CurrencyEnum::RUB,
                status: PaymentStatusEnum::PENDING,
                created_at: new \DateTimeImmutable(),
            );

            $this->paymentRepository->store($payment);

            return $payment;
        });
    }
}
