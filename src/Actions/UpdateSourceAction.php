<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use FromHome\Cloudimg\Events\SourceWasUpdated;
use FromHome\Cloudimg\Exceptions\SourceDoesNotExist;
use FromHome\Cloudimg\Contract\Models\SourceInterface;
use FromHome\Cloudimg\Contract\Repositories\SourceRepositoryInterface;

final class UpdateSourceAction
{
    private Dispatcher $event;

    private SourceRepositoryInterface $repository;

    public function __construct(Dispatcher $event, SourceRepositoryInterface $repository)
    {
        $this->event = $event;
        $this->repository = $repository;
    }

    public function handle(int $id, array $attributes): SourceInterface
    {
        $source = $this->repository->findUsingId($id);

        if ($source === null) {
            throw SourceDoesNotExist::withId($id);
        }

        $source->fill($attributes);
        $source->save();

        $this->event->dispatch(new SourceWasUpdated($source));

        return $source;
    }
}
