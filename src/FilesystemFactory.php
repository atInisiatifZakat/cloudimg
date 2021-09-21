<?php

declare(strict_types=1);

namespace FromHome\Cloudimg;

use Aws\S3\S3Client;
use Illuminate\Support\Arr;
use Illuminate\Filesystem\Cache;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AdapterInterface;
use Illuminate\Contracts\Cache\Factory;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\Cached\CachedAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\Cached\Storage\AbstractCache;
use League\Flysystem\AwsS3v3\AwsS3Adapter as S3Adapter;
use League\Flysystem\Cached\Storage\Memory as MemoryStore;
use FromHome\Cloudimg\Contract\Models\AwsCompatibleInterface;

final class FilesystemFactory
{
    private Factory $cache;

    public function __construct(Factory $cache)
    {
        $this->cache = $cache;
    }

    public function createLocalFilesystem(string $path): FilesystemInterface
    {
        return new Filesystem(new Local($path));
    }

    public function createLocalCacheFilesystem(): FilesystemInterface
    {
        return $this->createLocalFilesystem(
            \storage_path('cloudimg/cache')
        );
    }

    public function createS3Filesystem(AwsCompatibleInterface $aws): FilesystemInterface
    {
        $config = \array_merge($aws->getAwsConfig(), [
            'cache' => [],
            // Enable cache by default
        ]);

        $s3Config = $this->formatS3Config($config);

        $root = $s3Config['root'] ?? null;

        $options = $config['options'] ?? [];

        $streamReads = $config['stream_reads'] ?? false;

        return $this->createFlysystem(
            new S3Adapter(new S3Client($s3Config), $s3Config['bucket'], $root, $options, $streamReads),
            $config
        );
    }

    private function formatS3Config(array $config): array
    {
        $config += [
            'version' => 'latest',
        ];

        if (! empty($config['key']) && ! empty($config['secret'])) {
            $config['credentials'] = Arr::only($config, ['key', 'secret', 'token']);
        }

        return $config;
    }

    private function createFlysystem(AdapterInterface $adapter, array $config): FilesystemInterface
    {
        /** @var array|null $cache */
        $cache = Arr::pull($config, 'cache');

        $config = Arr::only($config, ['visibility', 'disable_asserts', 'url', 'temporary_url']);

        $adapter = new CachedAdapter($adapter, $this->createCacheStore($cache));

        return new Flysystem($adapter, count($config) > 0 ? $config : null);
    }

    private function createCacheStore(?array $config = null): AbstractCache
    {
        if ($config === null) {
            return new MemoryStore();
        }

        return new Cache(
            $this->cache->store($config['store'] ?? null),
            $config['prefix'] ?? 'flysystem',
            $config['expire'] ?? null
        );
    }
}
