<?php

namespace Yxx\LaravelPluginMarket\Http\Middleware;

use Illuminate\Support\Facades\Gate;

class Authorize
{
    public function handle($request, $next)
    {
        if (Gate::denies('viewPluginMarket')) {
            abort(403);
        }
        return $next($request);
    }
}
