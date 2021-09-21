<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Exceptions;

use InvalidArgumentException;

final class NotASubdomainException extends InvalidArgumentException
{
    public static function withHostname(int $hostname): self
    {
        return new self("Hostname `{$hostname}` does not include a subdomain.");
    }
}
