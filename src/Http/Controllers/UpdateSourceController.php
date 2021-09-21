<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Controllers;

use Illuminate\Http\Request;
use FromHome\Cloudimg\Actions\UpdateSourceAction;
use Illuminate\Auth\Access\AuthorizationException;
use FromHome\Cloudimg\Exceptions\SourceDoesNotExist;
use FromHome\Cloudimg\Http\Resources\SourceResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

final class UpdateSourceController
{
    use AuthorizesRequests;

    /**
     * @throws AuthorizationException
     */
    public function __invoke(int $sourceId, Request $request, UpdateSourceAction $action): SourceResource
    {
        $this->authorize('update', $sourceId);

        try {
            $source = $action->handle($sourceId, $request->input());

            return new SourceResource($source);
        } catch (SourceDoesNotExist $exception) {
            throw new BadRequestHttpException($exception->getMessage(), $exception);
        }
    }
}
