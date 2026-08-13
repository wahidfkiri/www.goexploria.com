<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Limitation du nombre de tentatives de connexion.
 *
 * Reprend le trait Illuminate\Foundation\Auth\ThrottlesLogins de Laravel 5.2,
 * retiré du framework depuis (il n'existe plus que dans laravel/ui). Seules les
 * méthodes réellement utilisées par AuthController sont conservées.
 */
trait ThrottlesLogins
{
    /**
     * Nombre maximal de tentatives avant blocage.
     */
    protected function maxLoginAttempts(): int
    {
        return property_exists($this, 'maxLoginAttempts') ? $this->maxLoginAttempts : 5;
    }

    /**
     * Durée du blocage, en minutes.
     */
    protected function lockoutTime(): int
    {
        return property_exists($this, 'lockoutTime') ? $this->lockoutTime : 1;
    }

    protected function hasTooManyLoginAttempts(Request $request): bool
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request),
            $this->maxLoginAttempts()
        );
    }

    protected function incrementLoginAttempts(Request $request): void
    {
        $this->limiter()->hit(
            $this->throttleKey($request),
            $this->lockoutTime() * 60
        );
    }

    protected function clearLoginAttempts(Request $request): void
    {
        $this->limiter()->clear($this->throttleKey($request));
    }

    protected function secondsRemainingOnLockout(Request $request): int
    {
        return $this->limiter()->availableIn($this->throttleKey($request));
    }

    /**
     * Clé de limitation : identifiant saisi + adresse IP.
     */
    protected function throttleKey(Request $request): string
    {
        $field = property_exists($this, 'username') ? $this->username : 'identifiant';

        return Str::transliterate(
            Str::lower((string) $request->input($field)).'|'.$request->ip()
        );
    }

    protected function limiter(): RateLimiter
    {
        return app(RateLimiter::class);
    }
}
