<?php

namespace App\Modules\Auth\Infrastructure\Persistence;

use App\Modules\Auth\Application\Contract\GenerateUuidInterface;
use Illuminate\Support\Str;

class IlluminateFacadeGenerateUuid implements GenerateUuidInterface
{
    public function handle(): string
    {
        return Str::uuid()->toString();
    }
}
