<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Controllers;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use FromHome\Cloudimg\GlideServerFactory;
use Illuminate\Contracts\Debug\ExceptionHandler;
use FromHome\Cloudimg\Exceptions\SourceDoesNotExist;
use Symfony\Component\HttpFoundation\StreamedResponse;
use FromHome\Cloudimg\Exceptions\NotASubdomainException;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;

final class RenderAssetController
{
    public function __invoke(
        string $path,
        Request $request,
        SourceRepositoryInterface $repository,
        GlideServerFactory $serverFactory,
        ExceptionHandler $handler
    ): StreamedResponse {
        try {
            $domain = $request->getHost();

            $source = $repository->findUsingDomain($domain);

            if ($source === null) {
                throw SourceDoesNotExist::withDomain($domain);
            }

            $server = $serverFactory->makeFromSource($source);

            /** @psalm-var StreamedResponse */
            return $server->getImageResponse($path, (array) $request->query());
        } catch (Exception $exception) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $handler->report($exception);

            return $this->renderExceptionImage(
                \config('cloudimg.error.not_found'),
                $serverFactory
            );
        }
    }

    private function renderExceptionImage(string $path, GlideServerFactory $serverFactory): StreamedResponse
    {
        $server = $serverFactory->makeLocalAdapterServer();

        /** @psalm-var StreamedResponse */
        return $server->getImageResponse($path, []);
    }

    private function makeSubdomain(string $hostname): string
    {
        $parts = \explode('.', $hostname);

        $isLocalhost = \count($parts) === 1;
        $isIpAddress = \count(\array_filter($parts, 'is_numeric')) === \count($parts);

        $notADomain = $isLocalhost || $isIpAddress;

        if ($notADomain) {
            throw new NotASubdomainException($hostname);
        }

        return (string) Arr::first($parts);
    }
}
