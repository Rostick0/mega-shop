<?php

namespace App\Modules\Auth\Infrastructure\Service;

use App\Modules\Auth\Application\Contract\GenerateUuidInterface;
use App\Modules\Auth\Application\Contract\TokenServiceInterface;
use App\Modules\Auth\Domain\Dto\AccessAndRefreshTokens;
use App\Modules\Auth\Domain\Dto\AccessToken;
use App\Modules\Auth\Domain\Dto\RefreshToken;
use App\Modules\Auth\Domain\Dto\RefreshTokenPayload;
use App\Modules\Auth\Domain\Dto\TokenPayload;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class JwtTokenService implements TokenServiceInterface
{
    public function __construct(
        private string $jwtSecret,
        private GenerateUuidInterface $generateUuid,
    ) {}

    public function issueAccessToken(int $userId): AccessToken
    {
        $expiresAt = new \DateTimeImmutable('+15 minutes');

        $payload = [
            'sub' => $userId,
            'exp' => $expiresAt->getTimestamp(),
            'iat' => time(),
            'type' => 'access',
        ];

        $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');

        return new AccessToken($jwt, $expiresAt);
    }

    public function issueRefreshToken(int $userId): RefreshToken
    {
        $expiresAt = new \DateTimeImmutable('+30 days');

        $jti = $this->generateUuid->handle();

        $payload = [
            'jti' => $jti,
            'sub' => $userId,
            'exp' => $expiresAt->getTimestamp(),
            'type' => 'refresh',
        ];


        $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');

        return new RefreshToken($jwt, $jti, $expiresAt);
    }

    public function parseAccessToken(string $token): TokenPayload
    {
        $decoded = JWT::decode(
            $token,
            new Key($this->jwtSecret, 'HS256')
        );

        if (($decoded->type ?? null) !== 'access') {
            throw new Exception('Token is invalid');
        }

        return new TokenPayload(
            userId: (int) $decoded->sub,
        );
    }

    public function parseRefreshToken(string $token): RefreshTokenPayload
    {
        $decoded = JWT::decode(
            $token,
            new Key($this->jwtSecret, 'HS256')
        );

        if (($decoded->type ?? null) !== 'refresh') {
            throw new Exception('Token is invalid');
        }

        return new RefreshTokenPayload(
            userId: (int) $decoded->sub,
            jti: (string) $decoded->jti,
        );
    }

    public function refresh(string $refreshToken): AccessAndRefreshTokens
    {
        $decoded = $this->parseRefreshToken($refreshToken);

        return new AccessAndRefreshTokens(
            $this->issueAccessToken((int) $decoded->userId),
            $this->issueRefreshToken((int) $decoded->userId)
        );
    }
}
