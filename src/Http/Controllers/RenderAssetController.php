<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use FromHome\Cloudimg\Supports\Path;
use FromHome\Cloudimg\GlideServerFactory;
use Illuminate\Contracts\Debug\ExceptionHandler;
use League\Glide\Responses\SymfonyResponseFactory;
use FromHome\Cloudimg\Exceptions\SourceDoesNotExist;
use Symfony\Component\HttpFoundation\StreamedResponse;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;

final class RenderAssetController
{
    public function __invoke(
        string $path,
        Request $request,
        SourceRepositoryInterface $repository,
        GlideServerFactory $serverFactory,
        ExceptionHandler $handler,
        SymfonyResponseFactory $responseFactory
    ): StreamedResponse {
        try {
            $domain = $request->getHost();

            $source = $repository->findUsingDomain($domain);

            if ($source === null) {
                throw SourceDoesNotExist::withDomain($domain);
            }

            $server = $serverFactory->makeFromSource($source);

            if (Path::isImage($path)) {
                /** @psalm-var StreamedResponse */
                $response = $server->getImageResponse($path, (array) $request->query());
            
                $response->headers->set('Access-Control-Allow-Origin', '*');
                
                return $response;
            }

            /** @psalm-var StreamedResponse */
            $response = $responseFactory->create($server->getSource(), $path);

            $response->headers->set('Access-Control-Allow-Origin', '*');
        
            return $response;
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
}
