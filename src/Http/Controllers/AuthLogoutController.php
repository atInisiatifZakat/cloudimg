<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\Resources\Json\JsonResource;

final class AuthLogoutController
{
    public function __invoke(Factory $factory, Request $request): JsonResource
    {
        /** @var StatefulGuard $guard */
        $guard = $factory->guard('web');

        if ($guard->check()) {
            $guard->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }

        return new JsonResource([
            'success' => true,
            'message' => 'Logout success',
        ]);
    }
}
