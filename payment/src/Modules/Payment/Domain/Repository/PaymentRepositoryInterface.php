<?php

namespace App\Modules\Payment\Domain\Repository;

use App\Modules\Payment\Domain\Entity\Payment;

interface PaymentRepositoryInterface
{
    public function store(Payment $payment): void;
    public function update(Payment $payment): void;
}
