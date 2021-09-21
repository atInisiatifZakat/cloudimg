<?php

declare(strict_types=1);

use FromHome\Cloudimg\Routes;
use Illuminate\Routing\Router;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

return static function (Router $router): void {
    $router->get('/token/csrf', [CsrfCookieController::class, 'show']);

    Routes::create($router)->authApi();

    $router->middleware('auth:sanctum')->group(static function (Router $router): void {
        Routes::create($router)
            ->sourceApi()
            ->profileApi();
    });
};
