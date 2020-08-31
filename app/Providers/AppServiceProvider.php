<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;
use Vanilo\Category\Contracts\Taxon as TaxonContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        $this->app->concord->registerModel(\Konekt\User\Contracts\User::class, \App\User::class);
        $this->app->concord->registerModel(
            TaxonContract::class, \App\Ctic\Category\Models\Taxon::class
        );
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
