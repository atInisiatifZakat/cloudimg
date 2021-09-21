<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;

final class HandleInertiaRequests extends Middleware
{
    public function share(Request $request)
    {
        return \array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
        ]);
    }
}
