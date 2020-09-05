<?php

namespace App\Providers;

use App\Ctic\Product\Http\Requests\CreateGroup;
use App\Ctic\Product\Http\Requests\UpdateGroup;
use App\Ctic\Product\Models\Group;
use Illuminate\Support\ServiceProvider;
use Schema;
use Vanilo\Category\Contracts\Taxon as TaxonContract;
use Vanilo\Product\Contracts\Product as ProductContract;
use Illuminate\Foundation\AliasLoader;

class AppServiceProvider extends ServiceProvider
{
    protected $requests = [
        CreateGroup::class,
        UpdateGroup::class,
    ];

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
        $this->app->concord->registerModel(
            ProductContract::class, \App\Ctic\Product\Models\Product::class
        );
        $this->app->concord->registerModel(\App\Ctic\Product\Contracts\Group::class, Group::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->booting(function() {
            $loader = AliasLoader::getInstance();
            $loader->alias(\Vanilo\Framework\Http\Controllers\ProductController::class, \App\Http\Controllers\Admin\ProductController::class);
            $loader->alias(\Vanilo\Framework\Search\ProductFinder::class, \App\Ctic\Product\Search\ProductFinder::class);
        });
    }
}
