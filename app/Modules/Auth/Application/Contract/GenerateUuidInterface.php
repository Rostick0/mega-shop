<?php

namespace App\Modules\Auth\Application\Contract;

interface GenerateUuidInterface
{
    public function handle(): string;
}
