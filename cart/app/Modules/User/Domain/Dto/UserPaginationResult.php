<?php

namespace App\Modules\User\Domain\Dto;

class UserPaginationResult
{
    /**
     * @param GetUserResponse[] $data
     */
    public function __construct(
        public array $data,
        public int $total,
        public int $current_page,
        public int $last_page,
    ) {}
}
