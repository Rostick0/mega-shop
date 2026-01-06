<?php

namespace App\Modules\Auth\Infrastructure\Service;

use App\Modules\Auth\Application\Entity\TokenServiceInterface;
use App\Modules\Auth\Domain\Dto\AccessToken;
use App\Modules\Auth\Domain\Dto\RefreshToken;
use Exception;
use TokenPayload;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class JwtTokenService implements TokenServiceInterface
{
    public function __construct(
        private string $jwtSecret
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

        $payload = [
            'sub' => $userId,
            'exp' => $expiresAt->getTimestamp(),
            'type' => 'refresh',
        ];

        $jwt = JWT::encode($payload, $this->jwtSecret, 'HS256');

        return new RefreshToken($jwt, $expiresAt);
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

    public function refresh(string $refreshToken): AccessToken
    {
        $decoded = JWT::decode(
            $refreshToken,
            new Key($this->jwtSecret, 'HS256')
        );

        if (($decoded->type ?? null) !== 'refresh') {
            throw new Exception('Token is invalid');
        }

        return $this->issueAccessToken(
            (int) $decoded->sub
        );
    }
}
