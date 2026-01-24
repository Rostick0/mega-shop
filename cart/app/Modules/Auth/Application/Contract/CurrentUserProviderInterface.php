<?php

namespace App\Modules\Auth\Application\Contract;

use App\Modules\User\Domain\Entity\User;

interface CurrentUserProviderInterface
{
    public function get(): ?User;
}
