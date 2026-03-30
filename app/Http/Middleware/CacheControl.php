<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheControl
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->is('*.css') || $request->is('*.js') || $request->is('*.jpg') || $request->is('*.jpeg') || $request->is('*.png') || $request->is('*.webp') || $request->is('*.svg') ) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000');
        }

        return $response;
    }
}