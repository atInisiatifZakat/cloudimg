<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Providers;

use FromHome\Cloudimg\Models\Source;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use FromHome\Cloudimg\Policies\SourcePolicy;
use FromHome\Cloudimg\Contract\Models\SourceInterface;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;

final class CloudimgServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    protected array $policies = [
        Source::class => SourcePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/cloudimg.php' => $this->app->configPath(),
            ], 'cloudimg-config');

            $migrationPath = $this->app->databasePath('migrations');

            $this->publishes([
                __DIR__ . '/../../database/migrations/2021_08_30_185910_create_sources_table.php' => $migrationPath,
            ], 'cloudimg-migration');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/cloudimg.php', 'cloudimg');

        $this->app->bind(SourceInterface::class, config('cloudimg.models.source'));
        $this->app->bind(SourceRepositoryInterface::class, config('cloudimg.repositories.source'));
    }

    protected function registerPolicies(): void
    {
        /**
         * @var string $key
         * @var string $value
         */
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }
}
