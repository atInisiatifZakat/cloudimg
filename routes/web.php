<?php

declare(strict_types=1);

use FromHome\Cloudimg\Routes;
use Illuminate\Routing\Router;
use Inertia\Middleware as HandleInertiaRequests;

return static function (Router $router): void {
    $router->redirect('/', '/home');

    $router->middleware([HandleInertiaRequests::class])->group(static function (Router $router): void {
        Routes::create($router)->authPage();

        $router->middleware('auth')->group(static function (Router $router): void {
            Routes::create($router)->homePage();
        });
    });
};
