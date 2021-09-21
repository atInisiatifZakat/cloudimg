<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use FromHome\Cloudimg\Http\Resources\ProviderResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;

final class ShowProviderController
{
    use AuthorizesRequests;

    /**
     * @throws AuthorizationException
     */
    public function __invoke(int $sourceId, SourceRepositoryInterface $repository): ProviderResource
    {
        $this->authorize('view', $sourceId);

        return new ProviderResource(
            $repository->findUsingId($sourceId)
        );
    }
}
