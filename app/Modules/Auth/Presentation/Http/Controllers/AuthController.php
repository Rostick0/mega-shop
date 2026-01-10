<?php

namespace App\Modules\Auth\Presentation\Http\Controllers;

use App\Modules\Auth\Application\Contract\PayloadAuthRequest;
use App\Modules\Auth\Application\Contract\TokenServiceInterface;
use App\Modules\Auth\Application\Contract\TransactionInterface;
use App\Modules\Auth\Application\Queries\GetCurrentUserQuery\GetCurrentUserQueryHandler;
use App\Modules\Auth\Application\Queries\GetUserByEmail\GetUserByEmailHandler;
use App\Modules\Auth\Application\Queries\GetUserByEmail\GetUserByEmailQuery;
use App\Modules\Auth\Application\UseCase\RefreshAuth\RefreshAuthHandler;
use App\Modules\Auth\Application\UseCase\StoreRefreshToken\StoreRefreshTokenRequest;
use App\Modules\Auth\Domain\Repositories\RefreshTokenRepositoryInterface;
use App\Modules\Auth\Infrastructure\Service\CreateUser;
use App\Modules\Auth\Infrastructure\Service\VerifyPasswordService;
use App\Modules\Auth\Presentation\Http\Requests\LoginAuthFormRequest;
use App\Modules\Auth\Presentation\Http\Requests\RegisgerAuthFormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController
{
    public function __construct(
        public TokenServiceInterface $tokenService,
        public RefreshTokenRepositoryInterface $refreshTokenRepository,
        public TransactionInterface $transaction
    ) {}

    public function register(RegisgerAuthFormRequest $formRequest, CreateUser $createUser,): JsonResponse
    {
        $this->transaction->beginTransaction();

        $user = $createUser->handle($formRequest);

        $accessToken = $this->tokenService->issueAccessToken($user->id);
        $refreshToken = $this->tokenService->issueRefreshToken($user->id);

        $this->refreshTokenRepository->store(new StoreRefreshTokenRequest(
            jti: $refreshToken->jti,
            // jti: (string) Str::uuid(),
            user_id: $user->id,
            expires_at: $refreshToken->time,
        ));

        $this->transaction->commit();

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

        $this->refreshTokenRepository->store(new StoreRefreshTokenRequest(
            jti: $refreshToken->jti,
            user_id: $authUser->user->id,
            expires_at: $refreshToken->time,
        ));

        return new JsonResponse([
            'data' => new PayloadAuthRequest(
                accessToken: $accessToken,
                refreshToken: $refreshToken,
                user: $authUser->user,
            ),
        ]);
    }

    public function refresh(Request $request, RefreshAuthHandler $handler): JsonResponse
    {

        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        $oldToken = $this->tokenService->parseRefreshToken($token);

        $refreshToken = $this->refreshTokenRepository->getByJti($oldToken->jti);

        if ($refreshToken->isExpired(new \DateTimeImmutable) || $refreshToken->isRevoked()) {
            return new JsonResponse(['message' => 'Invalid token'], 403);
        }

        $tokens = $handler->handle($token);

        $this->transaction->beginTransaction();

        $this->refreshTokenRepository->store(new StoreRefreshTokenRequest(
            jti: $tokens->refreshToken->jti,
            user_id: $refreshToken->user_id,
            expires_at: $tokens->refreshToken->time,
        ));

        $this->refreshTokenRepository->revoke($oldToken->jti);

        $this->transaction->commit();

        return new JsonResponse([
            'data' => $tokens
        ]);
    }


    public function me(GetCurrentUserQueryHandler $handler): JsonResponse
    {
        return new JsonResponse($handler->handle());
    }
}
