<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use FromHome\Cloudimg\Contract\Models\SourceInterface;

final class ProviderResource extends JsonResource
{
    public function toArray($request): array
    {
        return $this->mapResource(
            $this->resource
        );
    }

    public function mapResource(SourceInterface $source): array
    {
        return [
            'id' => $source->getId(),
            'provider' => $source->getProviderName(),
            'key' => $source->getPlainKey(),
            'secret' => $source->getPlainSecret(),
        ];
    }
}
