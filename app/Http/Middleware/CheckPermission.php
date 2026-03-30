<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $module
     * @param  string  $action
     * @return mixed
     */
    public function handle($request, Closure $next, $module, $action)
    {
        $user = Auth::guard('admin')->user(); // Use the admin guard

        if (auth()->guard('admin')->user()->roles->contains('id', 1)){
            return $next($request);
        }

        if (!$user || !$user->hasPermissionForAction($module, $action)) {
            return response()->view('errors.permission_denied', [], 403); // Return a permission denied view
        }

        return $next($request);
    }
}
