<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Policies;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Access\HandlesAuthorization;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;

final class SourcePolicy
{
    use HandlesAuthorization;

    private SourceRepositoryInterface $repository;

    public function __construct(SourceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function view(Authenticatable $user, int $sourceId): bool
    {
        $source = $this->repository->findUsingId($sourceId);

        return $source && $user->getAuthIdentifier() === $source->user()->getModel()->getKey();
    }

    public function update(Authenticatable $user, int $sourceId): bool
    {
        $source = $this->repository->findUsingId($sourceId);

        return $source && $user->getAuthIdentifier() === $source->user()->getModel()->getKey();
    }
}
