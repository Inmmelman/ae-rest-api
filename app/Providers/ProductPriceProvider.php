<?php

namespace App\Providers;

use App\Helpers\ProductPriceResolverHelper;
use Illuminate\Support\ServiceProvider;

class ProductPriceProvider extends ServiceProvider
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
       $this->app->singleton('App\Helpers\ProductPriceResolverHelper', function(){
           return new ProductPriceResolverHelper();
      });
    }
}
