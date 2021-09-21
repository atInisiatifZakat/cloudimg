<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Http\Request;
use FromHome\Cloudimg\Routes;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

final class RouteServiceProvider extends ServiceProvider
{
    /**
     * @psalm-suppress UnresolvableInclude
     * @psalm-suppress PossiblyUndefinedArrayOffset
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function (): void {
            $domain = \parse_url(\config('app.url'))['host'];

            Route::prefix('api')
                ->domain($domain)
                ->middleware('api')
                ->group(require base_path('routes/api.php'));

            Route::middleware('web')
                ->domain($domain)
                ->group(require base_path('routes/web.php'));
        });

        $this->mapAssetRoutes();
    }

    protected function mapAssetRoutes(): void
    {
        /** @var SourceRepositoryInterface $source */
        $source = $this->app->make(SourceRepositoryInterface::class);

        $source->fetchCachedDomains()->each(static function (string $domain): void {
            Route::middleware('web')
                ->domain($domain)
                ->group(static function (Router $router): void {
                    Routes::create($router)->renderAsset();
                });
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            /** @psalm-suppress PossiblyNullArgument */
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
