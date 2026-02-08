<?php

namespace App\Modules\Order\Application\Dto;

use App\Modules\Order\Domain\Entity\OrderStatusEnum;
use DateTimeImmutable;

class OrderSearchCriteria
{
    public function __construct(
        public readonly ?string $title = null,
        public readonly ?int $user_id = null,
        public readonly ?DateTimeImmutable $dateFrom = null,
        public readonly ?DateTimeImmutable $dateTo = null,
        public readonly ?OrderStatusEnum $status = null,
    ) {}
}
