<?php

final class TokenPayload
{
    public function __construct(
        public readonly int $userId,
    ) {}
}
