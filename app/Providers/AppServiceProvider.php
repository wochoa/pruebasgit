<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Operacion;
use App\Observers\OperacionObserver;
use Illuminate\Support\Facades\Schema;

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
        // Schema::defaultStringLength(191);
        Operacion::observe(OperacionObserver::class);
        
    }
}
