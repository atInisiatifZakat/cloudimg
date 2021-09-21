<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Resources;

use Illuminate\Support\Arr;
use Illuminate\Http\Resources\Json\JsonResource;
use FromHome\Cloudimg\Contract\Models\SourceInterface;

final class SourceResource extends JsonResource
{
    public function toArray($request): array
    {
        return $this->mapResource(
            $this->resource
        );
    }

    public function mapResource(SourceInterface $source): array
    {
        $resource = $source->toArray();

        if (\array_key_exists('user', $resource) && $resource['user'] !== null) {
            $resource['user'] = Arr::only($resource['user'], ['id', 'name', 'email']);
        }

        return $resource;
    }
}
