<?php

namespace App\Modules\Auth\Presentation\Http\Controllers;

use App\Modules\Auth\Application\Entity\PayloadAuthRequest;
use App\Modules\Auth\Application\Entity\TokenServiceInterface;
use App\Modules\Auth\Infrastructure\Service\RegistrationUser;
use App\Modules\Auth\Presentation\Http\Requests\RegisgerAuthFormRequest;
use Illuminate\Http\JsonResponse;

class AuthController
{
    public function __construct(
        public TokenServiceInterface $tokenService
    ) {}

    public function register(RegisgerAuthFormRequest $formRequest, RegistrationUser $registrationUser): JsonResponse
    {
        $user = $registrationUser->handle($formRequest);

        $accessToken = $this->tokenService->issueAccessToken($user->id);
        $refreshToken = $this->tokenService->issueRefreshToken($user->id);

        return new JsonResponse([
            'data' => new PayloadAuthRequest(
                accessToken: $accessToken,
                refreshToken: $refreshToken,
                user: $user,
            ),
        ]);
    }
}
