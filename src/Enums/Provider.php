<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Enums;

use MyCLabs\Enum\Enum;

/**
 * @psalm-immutable
 */
final class Provider extends Enum
{
    private const AWS = 'AWS';

    public static function AWS(): self
    {
        return new self(self::AWS);
    }
}
