<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Konekt\Menu\Facades\Menu;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();

        $this->addMenuItems();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    protected function addMenuItems()
    {
        if ($menu = Menu::get('appshell')) {
            $shop = $menu->getItem('shop');
            $shop->addSubItem('product_groups', __('ctic_admin.groups'), ['route' => 'admin.group.index'])->data('icon', 'format-list-bulleted');
            $settings = $menu->getItem('settings_group');
            $settings->addSubItem('payment_methods', __('ctic_admin.payment_methods'), ['route' => 'admin.payment_method.index'])->data('icon', 'format-list-bulleted');
            $settings->addSubItem('shipping_methods', __('ctic_admin.shipping_methods'), ['route' => 'admin.shipping_method.index'])->data('icon', 'format-list-bulleted');
        }
    }
}
