<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Priority: session -> cookie -> user->locale -> app.fallback_locale
        $locale =
            session('locale') ??
            $request->cookie('locale') ??
            optional($request->user())->locale ??
            config('app.locale');

        // optional: sanitize to allowed codes from DB
        // $allowed = \App\Models\Language::pluck('code')->all();
        // if (!in_array($locale, $allowed)) { $locale = config('app.locale'); }

        App::setLocale($locale);

        return $next($request);
    }
}
