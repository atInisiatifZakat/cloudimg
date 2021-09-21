<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Controllers;

use Illuminate\Http\Request;
use FromHome\Cloudimg\Http\Resources\SourceResourceCollection;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;

final class FilterSourceController
{
    public function __invoke(Request $request, SourceRepositoryInterface $repository): SourceResourceCollection
    {
        return new SourceResourceCollection(
            $repository->filter($request)
        );
    }
}
