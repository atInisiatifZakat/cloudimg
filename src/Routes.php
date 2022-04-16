<?php

declare(strict_types=1);

namespace FromHome\Cloudimg;

use Illuminate\Routing\Router;
use FromHome\Cloudimg\Http\Pages\AuthPage;
use FromHome\Cloudimg\Http\Pages\HomePage;
use FromHome\Cloudimg\Http\Controllers\ProfileController;
use FromHome\Cloudimg\Http\Controllers\AuthLoginController;
use FromHome\Cloudimg\Http\Controllers\AuthLogoutController;
use FromHome\Cloudimg\Http\Controllers\RenderAssetController;
use FromHome\Cloudimg\Http\Controllers\CreateSourceController;
use FromHome\Cloudimg\Http\Controllers\DetailSourceController;
use FromHome\Cloudimg\Http\Controllers\FilterSourceController;
use FromHome\Cloudimg\Http\Controllers\ShowProviderController;
use FromHome\Cloudimg\Http\Controllers\UpdateSourceController;
use FromHome\Cloudimg\Http\Middleware\PreventAccessMainDomain;

final class Routes
{
    private Router $router;

    private function __construct(Router $router)
    {
        $this->router = $router;
    }

    public static function create(Router $router): self
    {
        return new self($router);
    }

    public function authApi(): self
    {
        $this->router->post('/auth/login', AuthLoginController::class);
        $this->router->get('/auth/logout', AuthLogoutController::class);

        return $this;
    }

    public function profileApi(): self
    {
        $this->router->get('/profile', ProfileController::class);

        return $this;
    }

    public function sourceApi(): self
    {
        $this->router->get('/source', FilterSourceController::class);
        $this->router->post('/source', CreateSourceController::class);
        $this->router->get('/source/{sourceId}', DetailSourceController::class);
        $this->router->put('/source/{sourceId}', UpdateSourceController::class);
        $this->router->get('/source/{sourceId}/provider', ShowProviderController::class);

        return $this;
    }

    public function renderAsset(): self
    {
        $this->router->get('/{any}', RenderAssetController::class)
            ->where('any', '.*')
            ->middleware(PreventAccessMainDomain::class);

        return $this;
    }

    public function authPage(): self
    {
        $this->router->get('/auth/login', [AuthPage::class, 'login'])->name('login')->middleware('guest');

        return $this;
    }

    public function homePage(): self
    {
        $this->router->get('/home', HomePage::class);

        return $this;
    }
}
