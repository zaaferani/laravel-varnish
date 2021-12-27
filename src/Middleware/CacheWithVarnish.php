<?php

namespace Spatie\Varnish\Middleware;

use Closure;

class CacheWithVarnish
{
    public function handle($request, Closure $next, int $cacheTimeInMinutes = null)
    {
        try{
            $response = $next($request);
			if (method_exists($response,'withHeaders')){
                return $response->withHeaders([
                    config('varnish.cacheable_header_name') => '1',
                    'Cache-Control' => 'public, max-age='. 60 * ($cacheTimeInMinutes ?? config('varnish.cache_time_in_minutes')),
                ]);
			} else {
				$request->headers->set( config('varnish.cacheable_header_name'), '1');
				$request->headers->set( 'Cache-Control', 'public, max-age='. 60 * ($cacheTimeInMinutes ?? config('varnish.cache_time_in_minutes')));

			    return $next($request);
			}
	    } catch (\Exception $e){
		    return $next($request);
	    }        
    }
}
