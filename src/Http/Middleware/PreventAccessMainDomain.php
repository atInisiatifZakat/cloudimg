<?php

declare(strict_types=1);

namespace FromHome\Cloudimg\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class PreventAccessMainDomain
{
    /**
     * @psalm-suppress PossiblyUndefinedArrayOffset
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $domain = \parse_url(\config('app.url'))['host'];

        if ($request->getHost() === $domain) {
            throw new NotFoundHttpException();
        }

        return $next($request);
    }
}
