<?php

namespace FromHome\Cloudimg\Commands;

use Illuminate\Console\Command;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;

final class CacheSourceDomainCommand extends Command
{
    protected $name = 'cloudimg:domain-cache';

    protected $description = 'Cache and clear domain source.';

    public function handle(SourceRepositoryInterface $source): int
    {
        $this->info('Source domain cache cleared!');

        $source->fetchCachedDomains(true);

        $this->info('Source domain cached successfully!');

        return self::SUCCESS;
    }
}
