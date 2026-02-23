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
        $paymentModel->setExternalReference($payment->external_reference);
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
        $paymentModel->setExternalReference($payment->external_reference);
        $paymentModel->setProvider($payment->provider);
        $paymentModel->setProviderPaymentId($payment->provider_payment_id);
        $paymentModel->setAmount($payment->amount);
        $paymentModel->setCurrency($payment->currency);
        $paymentModel->setStatus($payment->status);

        return $paymentModel;
    }
}
