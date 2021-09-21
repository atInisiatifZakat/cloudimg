<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Exceptions;

use InvalidArgumentException;

final class SourceDoesNotExist extends InvalidArgumentException
{
    public static function withId(int $sourceId): self
    {
        return new self("There is no [source] with id `{$sourceId}`.");
    }

    public static function withDomain(string $domain): self
    {
        return new self("There is no [source] with domain `{$domain}`.");
    }
}
