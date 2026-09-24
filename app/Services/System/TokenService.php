<?php

namespace App\Services\System;

use Illuminate\Database\Eloquent\Model;

class TokenService
{
    /**
     * method generate a cryptographically secure random token
     * @param int $length number of random bytes (final string is twice as long, hex-encoded)
     */
    public static function generateToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * method generate a token guaranteed unique against a given model column,
     * retrying on the rare chance of a collision
     * @param class-string<Model> $modelClass
     */
    public static function generateUniqueToken(string $modelClass, string $column = 'token', int $length = 32): string
    {
        do {
            $token = self::generateToken($length);
        } while ($modelClass::where($column, $token)->exists());

        return $token;
    }

    /**
     * method generate a token together with its expiry timestamp,
     * matching the token/token_expired pair used across verification and reset flows
     */
    public static function generateTokenWithExpiry(int $expiresInMinutes = 120, int $length = 32): array
    {
        return [
            'token' => self::generateToken($length),
            'token_expired' => now()->addMinutes($expiresInMinutes),
        ];
    }
}
