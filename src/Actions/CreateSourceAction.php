<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use FromHome\Cloudimg\Events\SourceWasCreated;
use FromHome\Cloudimg\Contract\Models\SourceInterface;

final class CreateSourceAction
{
    private Dispatcher $event;

    private SourceInterface $source;

    public function __construct(Dispatcher $event, SourceInterface $source)
    {
        $this->event = $event;
        $this->source = $source;
    }

    public function handle(array $attributes): SourceInterface
    {
        $this->source->fill($attributes);

        $this->source->save();

        $this->event->dispatch(new SourceWasCreated($this->source));

        return $this->source;
    }
}
