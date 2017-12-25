<?php

namespace App\Providers;

use App\Services\BadiduMapService;
use App\Services\WeiXinService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(WeiXinService::class, function ($app) {
            return new WeiXinService();
        });

        $this->app->singleton(BadiduMapService::class, function ($app) {
            return new BadiduMapService();
        });
    }
}
