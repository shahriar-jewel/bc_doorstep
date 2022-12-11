<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SMSSendServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('SMSSend', function() {
            return new \App\SMSSend\SMSSend;
        });
    }
}
