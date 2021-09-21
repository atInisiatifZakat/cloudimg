<?php

declare(strict_types=1);

namespace FromHome\Cloudimg;

use League\Glide\Server;
use InvalidArgumentException;
use League\Glide\ServerFactory;
use FromHome\Cloudimg\Enums\Provider;
use Illuminate\Contracts\Cache\Factory;
use League\Flysystem\FilesystemInterface;
use League\Glide\Responses\LaravelResponseFactory;
use FromHome\Cloudimg\Contract\Models\SourceInterface;

final class GlideServerFactory
{
    private Factory $cache;

    public function __construct(Factory $cache)
    {
        $this->cache = $cache;
    }

    public function makeFromSource(SourceInterface $source): Server
    {
        return match ($source->getProviderName()) {
            (string) Provider::AWS() => $this->createAwsServer($source),
            default => throw new InvalidArgumentException('Provider not supported;')
        };
    }

    public function makeLocalAdapterServer(): Server
    {
        $factory = $this->getFilesystemFactory();

        return $this->createServer(
            $factory->createLocalFilesystem(
                \storage_path('cloudimg')
            ),
            [
                'cache' => $factory->createLocalCacheFilesystem(),
            ]
        );
    }

    private function createAwsServer(SourceInterface $source): Server
    {
        $factory = $this->getFilesystemFactory();

        return $this->createServer(
            $factory->createS3Filesystem($source),
            $this->createServerCache($source)
        );
    }

    private function createServer(FilesystemInterface $source, array $cache): Server
    {
        $server = ServerFactory::create(
            \array_merge([
                'source' => $source,
                'driver' => 'imagick',
                'max_image_size' => 1024 * 1024,
            ], $cache)
        );

        $server->setResponseFactory(new LaravelResponseFactory());

        return $server;
    }

    private function createServerCache(SourceInterface $source): array
    {
        return [
            'cache' => $this->getFilesystemFactory()->createLocalCacheFilesystem(),
            'cache_path_prefix' => \md5((string) $source->getId()),
        ];
    }

    private function getFilesystemFactory(): FilesystemFactory
    {
        return new FilesystemFactory($this->cache);
    }
}
