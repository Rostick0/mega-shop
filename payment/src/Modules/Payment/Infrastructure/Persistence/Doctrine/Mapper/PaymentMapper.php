<?php

namespace App\Modules\Payment\Infrastructure\Persistence\Doctrine\Mapper;

use App\Modules\Payment\Domain\Entity\Payment;
use App\Modules\Payment\Infrastructure\Persistence\Doctrine\Entity\PaymentModel;

class PaymentMapper
{
    public function toDoctrine(Payment $payment): PaymentModel
    {
        $paymentModel = new PaymentModel();

        $paymentModel->setId($payment->id);
        $paymentModel->setOrderId($payment->order_id);
        $paymentModel->setProvider($payment->provider);
        $paymentModel->setProviderPaymentId($payment->provider_payment_id);
        $paymentModel->setAmount($payment->amount);
        $paymentModel->setCurrency($payment->currency);
        $paymentModel->setStatus($payment->status);
        $paymentModel->setCreatedAt($payment->created_at);

        return $paymentModel;
    }

    public function updateForDoctrine(Payment $payment, PaymentModel $paymentModel): PaymentModel
    {
        $paymentModel->setOrderId($payment->order_id);
        $paymentModel->setProvider($payment->provider);
        $paymentModel->setProviderPaymentId($payment->provider_payment_id);
        $paymentModel->setAmount($payment->amount);
        $paymentModel->setCurrency($payment->currency);
        $paymentModel->setStatus($payment->status);

        return $paymentModel;
    }

    public function toDomain(PaymentModel $paymentModel): Payment
    {
        return new Payment(
            id: $paymentModel->getId(),
            order_id: $paymentModel->getOrderId(),
            provider: $paymentModel->getProvider(),
            provider_payment_id: $paymentModel->getProviderPaymentId(),
            amount: $paymentModel->getAmount(),
            currency: $paymentModel->getCurrency(),
            status: $paymentModel->getStatus(),
            created_at: $paymentModel->getCreatedAt()
        );
    }
}
