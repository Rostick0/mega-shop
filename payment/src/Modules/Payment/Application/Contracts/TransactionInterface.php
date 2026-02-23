<?php

namespace App\Modules\Payment\Application\Contracts;

interface TransactionInterface
{
    public function run(callable $callback): mixed;
}
