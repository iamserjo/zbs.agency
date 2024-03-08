<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Random\RandomException;

class TokenService
{
    private const string REGISTRATION_TOKEN_PREFIX = 'registration_token_';

    /**
     * @throws RandomException
     */
    public function generateToken(): string
    {
        // Generate a random token
        return bin2hex(random_bytes(config('services.token.registration_token_length')));
    }

    public function saveRegistrationToken(string $token, \DateTimeInterface $expires = null): void
    {
        Cache::put(self::REGISTRATION_TOKEN_PREFIX . $token, $expires);
    }

    public function isRegistrationTokenActive(?string $token): ?string
    {
        return Cache::get(self::REGISTRATION_TOKEN_PREFIX . $token, false);
    }

    public function deleteRegistrationToken(string $token): void
    {
        Cache::delete(self::REGISTRATION_TOKEN_PREFIX . $token);
    }
}
