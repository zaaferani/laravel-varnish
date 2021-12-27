<?php

namespace Spatie\Varnish\Middleware;

use Closure;


class NoCacheVarnish
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $max_age = config('varnish.cache_time_in_minutes') * 60;
        header('Set-Cookie: x-random=' . time() . " path=" . $request->path() . " Max-Age=$max_age");
        return $next($request);
    }
}
