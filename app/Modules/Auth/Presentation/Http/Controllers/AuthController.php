<?php

namespace App\Modules\Auth\Presentation\Http\Controllers;

use App\Modules\Auth\Application\Entity\PayloadAuthRequest;
use App\Modules\Auth\Application\Entity\TokenServiceInterface;
use App\Modules\Auth\Application\Queries\GetUserByEmail\GetUserByEmailHandler;
use App\Modules\Auth\Application\Queries\GetUserByEmail\GetUserByEmailQuery;
use App\Modules\Auth\Infrastructure\Service\LoginUserService;
use App\Modules\Auth\Infrastructure\Service\CreateUser;
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

    public function register(RegisgerAuthFormRequest $formRequest, CreateUser $CreateUser): JsonResponse
    {
        $user = $CreateUser->handle($formRequest);

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
        $authUser = $handler->handle(new GetUserByEmailQuery($formRequest->input('email')));

        if (!$authUser->user || !$verifyPasswordService->handle($formRequest, $authUser->credentials->password->value())) {
            return new JsonResponse(['message' => 'Invalid credentials'], 401);
        }

        $accessToken = $this->tokenService->issueAccessToken($authUser->user->id);
        $refreshToken = $this->tokenService->issueRefreshToken($authUser->user->id);

        return new JsonResponse([
            'data' => new PayloadAuthRequest(
                accessToken: $accessToken,
                refreshToken: $refreshToken,
                user: $authUser->user,
            ),
        ]);
    }

    // public function me() {

    //     dd(Auth::user());
    //     return 5;
    // }
}
