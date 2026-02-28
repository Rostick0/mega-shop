<?php

namespace Src\Modules\Shared\Application\Port;

interface ConsumerInterface
{
    public function consume(): void;
}
