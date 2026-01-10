<?php

namespace App\Modules\Auth\Application\Contract;

interface TransactionInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
}
