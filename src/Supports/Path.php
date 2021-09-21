<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Supports;

final class Path
{
    public static function isImage(string $path): bool
    {
        $parameters = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];

        if (in_array('jpg', $parameters, true) || \in_array('jpeg', $parameters, true)) {
            $parameters = \array_unique(\array_merge($parameters, ['jpg', 'jpeg']));
        }

        $guestExtension = \explode('.', $path);

        return $path !== '' && \in_array(\end($guestExtension), $parameters, true);
    }
}
