<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Resources\Json\JsonResource;
use FromHome\Cloudimg\Http\Requests\LoginRequest;

final class AuthLoginController
{
    /**
     * @throws ValidationException
     */
    public function __invoke(Factory $factory, LoginRequest $request, RateLimiter $rateLimiter): JsonResource
    {
        $this->ensureIsNotRateLimited($rateLimiter, $request);

        $throttleKey = $this->throttleKey($request);

        /** @var StatefulGuard $guard */
        $guard = $factory->guard('web');

        $login = $guard->attempt($request->only(['email', 'password']), true);

        if ($login === false) {
            $rateLimiter->hit($throttleKey);

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        $rateLimiter->clear($throttleKey);

        $request->session()->regenerate();

        $user = $guard->user();

        return new JsonResource($user);
    }

    /**
     * @throws ValidationException
     */
    private function ensureIsNotRateLimited(RateLimiter $rateLimiter, Request $request): void
    {
        $throttleKey = $this->throttleKey($request);

        if (! $rateLimiter->tooManyAttempts($throttleKey, 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = $rateLimiter->availableIn($throttleKey);

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    private function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }
}
