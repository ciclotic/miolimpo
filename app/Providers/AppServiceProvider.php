<?php

namespace App\Providers;

use App\Ctic\AddressBook\Models\AddressBook;
use App\Ctic\Product\Http\Requests\CreateGroup;
use App\Ctic\Product\Http\Requests\UpdateGroup;
use App\Ctic\Product\Models\Group;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Konekt\Gears\Defaults\SimplePreference;
use Konekt\Gears\Defaults\SimpleSetting;
use Konekt\Gears\UI\TreeBuilder;
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

        $this->app->bind(\Vanilo\Order\Contracts\OrderFactory::class, \App\Ctic\Order\Factories\OrderFactory::class);

        $this->bootSettings();

        $this->app->bind('appshell.settings_tree', function ($app) {
            $this->buildSettingsTree();
            return $app['appshell.settings_tree_builder']->getTree();
        });

        $this->bootPreferences();

        $this->app->bind('appshell.preferences_tree', function ($app) {
            $this->buildPreferencesTree();
            return $app['appshell.preferences_tree_builder']->getTree();
        });

        $this->bootFrameworkSettings();
    }

    protected function bootSettings()
    {
        $settingsRegistry = $this->app['gears.settings_registry'];

        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.language', 'es', ['es' => 'es', 'en' => 'en']));
        $settingsRegistry->add(new SimpleSetting('ctic.styles.colors.main', '#ff9320'));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.host', 'localhost'));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.username', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.password', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.port', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.encryption', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.from_address', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.from_name', ''));
    }

    protected function buildSettingsTree()
    {
        /** @var TreeBuilder $settingsTreeBuilder */
        $settingsTreeBuilder = $this->app['appshell.settings_tree_builder'];

        $settingsTreeBuilder->addRootNode('general', __('ctic_admin.general_settings'))
            ->addChildNode('general', 'general_app', __('ctic_admin.virtual_store'))
            ->addSettingItem('general_app', ['text', ['label' => __('ctic_admin.name')]], 'appshell.ui.name');

        $settingsTreeBuilder->addChildNode('general', 'defaults', __('ctic_admin.defaults'))
            ->addSettingItem('defaults', ['select', ['label' => __('ctic_admin.country')]], 'appshell.default.country')
            ->addSettingItem('defaults', ['select', ['label' => __('ctic_admin.language')]], 'ctic.general.defaults.language');

        $settingsTreeBuilder->addRootNode('mail', __('ctic_admin.mail'))
            ->addChildNode('mail', 'smtp', __('ctic_admin.smtp'))
            ->addSettingItem('smtp', ['text', ['label' => __('ctic_admin.host')]], 'ctic.mail.smtp.host')
            ->addSettingItem('smtp', ['text', ['label' => __('ctic_admin.username')]], 'ctic.mail.smtp.username')
            ->addSettingItem('smtp', ['text', ['label' => __('ctic_admin.password')]], 'ctic.mail.smtp.password')
            ->addSettingItem('smtp', ['text', ['label' => __('ctic_admin.port')]], 'ctic.mail.smtp.port')
            ->addSettingItem('smtp', ['text', ['label' => __('ctic_admin.encryption')]], 'ctic.mail.smtp.encryption')
            ->addSettingItem('smtp', ['text', ['label' => __('ctic_admin.from_address')]], 'ctic.mail.smtp.from_address')
            ->addSettingItem('smtp', ['text', ['label' => __('ctic_admin.from_name')]], 'ctic.mail.smtp.from_name')
        ;

        $settingsTreeBuilder->addRootNode('styles', __('ctic_admin.styles'))
            ->addChildNode('styles', 'colors', __('ctic_admin.colors'))
            ->addSettingItem('colors', ['text', ['label' => __('ctic_admin.main')]], 'ctic.styles.colors.main')
        ;
    }

    protected function bootPreferences()
    {
        $preferencesRegistry = $this->app['gears.preferences_registry'];

        $preferencesRegistry->add(new SimplePreference('ctic.user.general.defaults.language', 'es', ['es' => 'es', 'en' => 'en']));
    }

    protected function buildPreferencesTree()
    {
        /** @var TreeBuilder $preferencesTreeBuilder */
        $preferencesTreeBuilder = $this->app['appshell.preferences_tree_builder'];

        $preferencesTreeBuilder->addRootNode('general', __('ctic_admin.general_settings'))
            ->addChildNode('general', 'defaults', __('ctic_admin.defaults'))
            ->addSettingItem('defaults', ['select', ['label' => __('ctic_admin.language')]], 'ctic.user.general.defaults.language');
    }

    protected function bootFrameworkSettings()
    {
        app()->setLocale(setting('ctic.general.defaults.language') ?? 'es');

        $config = array(
            'driver'     => 'smtp',
            'host'       => setting('ctic.mail.smtp.host')?? env('MAIL_HOST'),
            'port'       => setting('ctic.mail.smtp.port')?? env('MAIL_PORT'),
            'from'       => array(
                'address' => setting('ctic.mail.smtp.from_address')?? env('MAIL_FROM_ADDRESS'),
                'name' => setting('ctic.mail.smtp.from_name')?? env('MAIL_FROM_NAME')
            ),
            'encryption' => setting('ctic.mail.smtp.encryption')?? env('MAIL_ENCRYPTION'),
            'username'   => setting('ctic.mail.smtp.username')?? env('MAIL_USERNAME'),
            'password'   => setting('ctic.mail.smtp.password')?? env('MAIL_PASSWORD'),
        );
        Config::set('mail', $config);
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
            $loader->alias(\Vanilo\Framework\Http\Controllers\MediaController::class, \App\Http\Controllers\Admin\MediaController::class);
            $loader->alias(\Vanilo\Framework\Search\ProductFinder::class, \App\Ctic\Product\Search\ProductFinder::class);
        });
    }
}
