<?php

namespace App\Providers;

use App\Ctic\AddressBook\Models\AddressBook;
use App\Ctic\Product\Http\Requests\CreateGroup;
use App\Ctic\Product\Http\Requests\UpdateGroup;
use App\Ctic\Product\Models\Group;
use Illuminate\Support\ServiceProvider;
use Schema;
use Vanilo\Category\Contracts\Taxon as TaxonContract;
use Vanilo\Product\Contracts\Product as ProductContract;
use Vanilo\Cart\Contracts\CartItem as CartItemContract;
use Vanilo\Cart\Contracts\Cart as CartContract;
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
        $this->app->concord->registerModel(
            CartItemContract::class, \App\Ctic\Cart\Models\CartItem::class
        );
        $this->app->concord->registerModel(
            CartContract::class, \App\Ctic\Cart\Models\Cart::class
        );
        $this->app->concord->registerModel(\App\Ctic\Product\Contracts\Group::class, Group::class);
        $this->app->concord->registerModel(\App\Ctic\AddressBook\Contracts\AddressBook::class, AddressBook::class);
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
