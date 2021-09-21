<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Contract\Models;

interface AwsCompatibleInterface
{
    public function getAwsConfig(): array;
}
