<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Contract\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use FromHome\Cloudimg\Contract\Models\SourceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SourceRepositoryInterface
{
    public function findUsingId(int $id): ?SourceInterface;

    public function findUsingDomain(string $domain): ?SourceInterface;

    public function filter(Request $request): LengthAwarePaginator;

    public function fetchStoredDomains(): Collection;

    public function fetchCachedDomains(bool $forget = false): Collection;
}
