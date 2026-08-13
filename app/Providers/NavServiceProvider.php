<?php

namespace App\Providers;

use App\Http\ViewComposers\NavComposer;
use App\Http\ViewComposers\SiteNavComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NavServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        View::composer('layouts.front.nav', NavComposer::class);
        View::composer('layouts.front.site.nav', SiteNavComposer::class);
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        //
    }
}
