<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Events;

use FromHome\Cloudimg\Contract\Models\SourceInterface;

final class SourceWasUpdated
{
    private SourceInterface $source;

    public function __construct(SourceInterface $source)
    {
        $this->source = $source;
    }

    public function getSource(): SourceInterface
    {
        return $this->source;
    }
}
