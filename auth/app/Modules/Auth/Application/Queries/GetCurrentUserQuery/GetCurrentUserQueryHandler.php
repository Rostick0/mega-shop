<?php

namespace App\Modules\Auth\Application\Queries\GetCurrentUserQuery;

use App\Modules\Auth\Application\Contract\CurrentUserProviderInterface;
use App\Modules\User\Domain\Dto\GetUserResponse;

class GetCurrentUserQueryHandler
{
    public function __construct(
        private CurrentUserProviderInterface $provider
    ) {}

    public function handle(): ?GetUserResponse
    {
        $user = $this->provider->get();

        if (!$user) {
            return null;
        }

        return new GetUserResponse(
            id: $user->id,
            name: $user->name,
            email: $user->email,
            email_verified_at: $user->email_verified_at,
        );
    }
}
