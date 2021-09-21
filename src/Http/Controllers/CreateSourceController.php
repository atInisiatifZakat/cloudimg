<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Controllers;

use FromHome\Cloudimg\Actions\CreateSourceAction;
use FromHome\Cloudimg\Http\Resources\SourceResource;
use FromHome\Cloudimg\Http\Requests\CreateOrUpdateSourceRequest;

final class CreateSourceController
{
    public function __invoke(CreateOrUpdateSourceRequest $request, CreateSourceAction $action): SourceResource
    {
        $source = $action->handle(
            \array_merge($request->input(), [
                'user_id' => $request->user()->getKey(),
            ])
        );

        return new SourceResource($source);
    }
}
