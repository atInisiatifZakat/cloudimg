<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

final class SourceResourceCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        /** @psalm-var array */
        return $this->resource->map(fn (SourceResource $resource) => $resource->toArray($request))->toArray();
    }
}
