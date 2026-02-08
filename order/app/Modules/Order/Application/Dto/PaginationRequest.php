<?php

namespace App\Modules\Order\Application\Dto;

class PaginationRequest
{
    public function __construct(
        public int $limit,
        public int $offset
    ) {}

    public function getPage()
    {
        if ($this->offset < 1) {
            return 1;
        }

        return floor($this->offset / $this->limit) + 1;
    }
}
