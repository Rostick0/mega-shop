<?php

namespace App\Modules\Auth\Presentation\Http\Controllers;

use App\Modules\Auth\Application\Entity\PayloadAuthRequest;
use App\Modules\Auth\Application\Entity\TokenServiceInterface;
use App\Modules\Auth\Application\Queries\GetUserByEmail\GetUserByEmailHandler;
use App\Modules\Auth\Application\Queries\GetUserByEmail\GetUserByEmailQuery;
use App\Modules\Auth\Infrastructure\Service\LoginUserService;
use App\Modules\Auth\Infrastructure\Service\RegistrationUser;
use App\Modules\Auth\Infrastructure\Service\VerifyPasswordService;
use App\Modules\Auth\Presentation\Http\Requests\LoginAuthFormRequest;
use App\Modules\Auth\Presentation\Http\Requests\RegisgerAuthFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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

    public function login(LoginAuthFormRequest $formRequest, VerifyPasswordService $verifyPasswordService, GetUserByEmailHandler $handler): JsonResponse
    {
        $user = $handler->handle(new GetUserByEmailQuery($formRequest->input('email')));

        // if (!$user) {
        //     // return;
        // }

        if ($verifyPasswordService->handle($formRequest, $user->password->value())) {
        }
        // $user = ;

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

    // public function me() {

    //     dd(Auth::user());
    //     return 5;
    // }
}
