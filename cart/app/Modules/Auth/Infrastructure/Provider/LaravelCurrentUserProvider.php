<?php

namespace App\Modules\Auth\Infrastructure\Provider;

use App\Modules\Auth\Application\Contract\CurrentUserProviderInterface;
use App\Modules\User\Domain\Entity\User;
use Illuminate\Support\Facades\Auth;

class LaravelCurrentUserProvider implements CurrentUserProviderInterface
{
    public function get(): ?User
    {
        $model = Auth::user();

        if (!$model) {
            return null;
        }

        return new User(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            email_verified_at: $model->email_verified_at,
        );
    }
}
