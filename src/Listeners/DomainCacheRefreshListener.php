<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Listeners;

use FromHome\Cloudimg\Events\SourceWasCreated;
use FromHome\Cloudimg\Events\SourceWasUpdated;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;

final class DomainCacheRefreshListener
{
    private SourceRepositoryInterface $source;

    public function __construct(SourceRepositoryInterface $source)
    {
        $this->source = $source;
    }

    /**
     * @param object $event
     */
    public function handle($event): void
    {
        if ($this->compatibleEvent($event)) {
            $this->source->fetchCachedDomains(true);
        }
    }

    /**
     * @param object $event
     */
    private function compatibleEvent($event): bool
    {
        return $event instanceof SourceWasCreated || $event instanceof SourceWasUpdated;
    }
}
