<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Pages;

use Inertia\Inertia;
use Inertia\Response;

final class HomePage
{
    public function __invoke(): Response
    {
        return Inertia::render('home');
    }
}
