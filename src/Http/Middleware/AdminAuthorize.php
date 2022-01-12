<?php

namespace Yxx\LaravelPluginMarket\Http\Middleware;

use Illuminate\Support\Facades\Auth;

class AdminAuthorize
{
    public function handle($request, $next)
    {
        if (Auth::user()->not_admin) {
            abort(403);
        }
        return $next($request);
    }
}
