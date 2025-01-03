<?php

namespace App\Providers;

use App\Facades\Cart;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(CartServiceProvider::class);

        //Registration Aliases Facade
        $loader = AliasLoader::getInstance();
        $loader->alias('Cart', Cart::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
