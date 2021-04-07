<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer( 'home', 'App\Http\ViewComposers\CategoryComposer' );
        view()->composer( 'layouts.app', 'App\Http\ViewComposers\CategoryComposer' );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
