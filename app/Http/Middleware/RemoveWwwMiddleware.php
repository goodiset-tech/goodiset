<?php

namespace App\Http\Middleware;

use Closure;

class RemoveWwwMiddleware
{
    public function handle($request, Closure $next)
    {
        if (str_starts_with($request->getHost(), 'www.')) {
            $request->headers->set('Host', substr($request->getHost(), 4));
            
            // You can also redirect to the non-www version if you want
            return redirect()->to($request->url());
        }

        return $next($request);
    }
}
