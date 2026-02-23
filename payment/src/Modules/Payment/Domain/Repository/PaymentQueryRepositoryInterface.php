<?php

namespace App\Modules\Payment\Domain\Repository;

use App\Modules\Payment\Domain\Entity\Payment;

interface PaymentQueryRepositoryInterface
{
    public function findById(string $id): ?Payment;
}
