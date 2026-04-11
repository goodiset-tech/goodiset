<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // \Artisan::call('migrate', ['--force' => true]);
        // \Artisan::call('db:seed', ['--force' => true]);
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
