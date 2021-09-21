<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProfileController
{
    public function __invoke(Request $request): JsonResource
    {
        return new JsonResource(
            $request->user()
        );
    }
}
