<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Hashids\Hashids;

class FakeIdServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Hashids\Hashids', function ($app) {
            return new Hashids(
                $app['config']['key']??'UpKey Incorporation',
                12,//at least 12 letter length
                'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890' //alphabet to use
            );
        });

        $this->app->alias('Hashids\Hashids', 'fakehashid');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
