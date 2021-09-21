<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use FromHome\Cloudimg\Events\SourceWasCreated;
use FromHome\Cloudimg\Events\SourceWasUpdated;
use FromHome\Cloudimg\Listeners\DomainCacheRefreshListener;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

final class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SourceWasCreated::class => [
            DomainCacheRefreshListener::class
        ],
        SourceWasUpdated::class => [
            DomainCacheRefreshListener::class
        ],
    ];
}
