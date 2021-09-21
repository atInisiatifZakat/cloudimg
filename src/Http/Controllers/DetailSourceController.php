<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use FromHome\Cloudimg\Http\Resources\SourceResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;

final class DetailSourceController
{
    use AuthorizesRequests;

    /**
     * @throws AuthorizationException
     */
    public function __invoke(int $sourceId, SourceRepositoryInterface $repository): SourceResource
    {
        $this->authorize('view', $sourceId);

        return new SourceResource(
            $repository->findUsingId($sourceId)
        );
    }
}
