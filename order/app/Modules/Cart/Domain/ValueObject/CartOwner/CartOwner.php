<?php

namespace App\Modules\Cart\Domain\ValueObject\CartOwner;

abstract class CartOwner
{
    abstract  public function value(): string;
    abstract public function type(): string;

    public function __toString(): string
    {
        return $this->type() . '.' . $this->value();
    }
}
