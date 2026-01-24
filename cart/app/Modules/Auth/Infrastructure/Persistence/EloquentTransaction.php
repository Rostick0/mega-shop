<?php

namespace App\Modules\Auth\Infrastructure\Persistence;

use App\Modules\Auth\Application\Contract\TransactionInterface;
use Illuminate\Support\Facades\DB;

class EloquentTransaction implements TransactionInterface
{
    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    public function commit(): void
    {
        DB::commit();
    }
}
