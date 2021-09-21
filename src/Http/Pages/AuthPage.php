<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Pages;

use Inertia\Inertia;
use Inertia\Response;

final class AuthPage
{
    public function login(): Response
    {
        return Inertia::render('auth/login');
    }
}
