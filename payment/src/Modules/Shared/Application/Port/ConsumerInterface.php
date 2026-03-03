<?php

namespace App\Modules\Shared\Application\Port;

interface ConsumerInterface
{
    public function consume(): void;
}
