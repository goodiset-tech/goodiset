<?php

namespace App\Providers;

use App\Console\Commands\ServeCommand;
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
        // Override the framework's ServeCommand with our custom version that
        // casts the --port option to int, fixing "Unsupported operand types:
        // string + int" on PHP 8+ (ServeCommand.php line 205).
        $this->app->extend('command.serve', function () {
            return new ServeCommand();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
