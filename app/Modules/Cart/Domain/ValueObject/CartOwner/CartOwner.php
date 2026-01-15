<?php

namespace App\Modules\Cart\Domain\ValueObject\CartOwner;

interface CartOwner
{
    public function value(): string;
    public function type(): string;
}
