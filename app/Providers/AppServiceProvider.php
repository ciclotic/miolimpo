<?php

namespace App\Providers;

use App\Ctic\AddressBook\Models\AddressBook;
use App\Ctic\PaymentMethod\Http\Requests\CreatePaymentMethod;
use App\Ctic\PaymentMethod\Http\Requests\UpdatePaymentMethod;
use App\Ctic\PaymentMethod\Models\PaymentMethod;
use App\Ctic\ShippingMethod\Http\Requests\CreateShippingMethod;
use App\Ctic\ShippingMethod\Http\Requests\UpdateShippingMethod;
use App\Ctic\ShippingMethod\Models\ShippingMethod;
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
use Vanilo\Order\Contracts\Order as OrderContract;
use Illuminate\Foundation\AliasLoader;

class AppServiceProvider extends ServiceProvider
{
    protected $requests = [
        CreateGroup::class,
        UpdateGroup::class,
        CreatePaymentMethod::class,
        UpdatePaymentMethod::class,
        CreateShippingMethod::class,
        UpdateShippingMethod::class,
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
        $this->app->concord->registerModel(TaxonContract::class, \App\Ctic\Category\Models\Taxon::class);
        $this->app->concord->registerModel(ProductContract::class, \App\Ctic\Product\Models\Product::class);
        $this->app->concord->registerModel(CartItemContract::class, \App\Ctic\Cart\Models\CartItem::class);
        $this->app->concord->registerModel(CartContract::class, \App\Ctic\Cart\Models\Cart::class);
        $this->app->concord->registerModel(OrderContract::class, \App\Ctic\Order\Models\Order::class);
        $this->app->concord->registerModel(\App\Ctic\Product\Contracts\Group::class, Group::class);
        $this->app->concord->registerModel(\App\Ctic\PaymentMethod\Contracts\PaymentMethod::class, PaymentMethod::class);
        $this->app->concord->registerModel(\App\Ctic\ShippingMethod\Contracts\ShippingMethod::class, ShippingMethod::class);
        $this->app->concord->registerModel(\App\Ctic\AddressBook\Contracts\AddressBook::class, AddressBook::class);

        $this->app->bind(
            \Vanilo\Order\Contracts\OrderFactory::class,
            \App\Ctic\Order\Factories\OrderFactory::class
        );

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
        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.logo_url', 'https://ulises.miolimpo.org/img/ulises_logo_400_white.png'));
        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.logo_url_dark', 'https://ulises.miolimpo.org/img/ulises_logo_180.png'));
        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.help', 'Ayuda'));
        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.help_url', '#'));
        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.reference', 'Ahorra 100€'));
        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.reference_url', '#'));
        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.blog', 'Blog'));
        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.blog_url', '#'));
        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.main_phrase', 'Mi Olimpo, pide tu comida online.'));
        $settingsRegistry->add(new SimpleSetting('ctic.general.defaults.thankyou_next_steps', 'Gracias por tu pedido, se te entregará lo más pronto posible después del pago.'));

        $settingsRegistry->add(new SimpleSetting('ctic.styles.colors.main', '#ff9320'));

        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.host', 'localhost'));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.username', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.password', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.port', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.encryption', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.from_address', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.mail.smtp.from_name', ''));

        $settingsRegistry->add(new SimpleSetting('ctic.payment.redsys.secret', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.payment.redsys.language', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.payment.redsys.currency', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.payment.redsys.merchantcode', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.payment.redsys.terminal', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.payment.redsys.sandbox', false));
        $settingsRegistry->add(new SimpleSetting('ctic.payment.paypal.business_email', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.payment.paypal.business_number', ''));
        $settingsRegistry->add(new SimpleSetting('ctic.payment.paypal.sandbox', false));
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
            ->addSettingItem('defaults', ['select', ['label' => __('ctic_admin.language')]], 'ctic.general.defaults.language')
            ->addSettingItem('defaults', ['text', ['label' => __('ctic_admin.logo_url')]], 'ctic.general.defaults.logo_url')
            ->addSettingItem('defaults', ['text', ['label' => __('ctic_admin.logo_url_dark')]], 'ctic.general.defaults.logo_url_dark')
            ->addSettingItem('defaults', ['text', ['label' => __('ctic_admin.help')]], 'ctic.general.defaults.help')
            ->addSettingItem('defaults', ['text', ['label' => __('ctic_admin.help_url')]], 'ctic.general.defaults.help_url')
            ->addSettingItem('defaults', ['text', ['label' => __('ctic_admin.reference')]], 'ctic.general.defaults.reference')
            ->addSettingItem('defaults', ['text', ['label' => __('ctic_admin.reference_url')]], 'ctic.general.defaults.reference_url')
            ->addSettingItem('defaults', ['text', ['label' => __('ctic_admin.blog')]], 'ctic.general.defaults.blog')
            ->addSettingItem('defaults', ['text', ['label' => __('ctic_admin.blog_url')]], 'ctic.general.defaults.blog_url')
            ->addSettingItem('defaults', ['text', ['label' => __('ctic_admin.main_phrase')]], 'ctic.general.defaults.main_phrase')
            ->addSettingItem('defaults', ['text', ['label' => __('ctic_admin.thankyou_next_steps')]], 'ctic.general.defaults.thankyou_next_steps');

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

        $settingsTreeBuilder->addRootNode('styles', __('ctic_admin.styles'))
            ->addChildNode('styles', 'colors', __('ctic_admin.colors'))
            ->addSettingItem('colors', ['text', ['label' => __('ctic_admin.main')]], 'ctic.styles.colors.main')
        ;

        $settingsTreeBuilder->addRootNode('payment', __('ctic_admin.payment'))
            ->addChildNode('payment', 'redsys', __('ctic_admin.redsys'))
            ->addSettingItem('redsys', ['text', ['label' => __('ctic_admin.secret')]], 'ctic.payment.redsys.secret')
            ->addSettingItem('redsys', ['text', ['label' => __('ctic_admin.language')]], 'ctic.payment.redsys.language')
            ->addSettingItem('redsys', ['text', ['label' => __('ctic_admin.currency')]], 'ctic.payment.redsys.currency')
            ->addSettingItem('redsys', ['text', ['label' => __('ctic_admin.mercant_code')]], 'ctic.payment.redsys.merchantcode')
            ->addSettingItem('redsys', ['text', ['label' => __('ctic_admin.terminal')]], 'ctic.payment.redsys.terminal')
            ->addSettingItem('redsys', ['checkbox', ['label' => 'Sandbox']], 'ctic.payment.redsys.sandbox')
            ->addChildNode('payment', 'paypal', __('ctic_admin.paypal'))
            ->addSettingItem('paypal', ['text', ['label' => __('ctic_admin.business_email')]], 'ctic.payment.paypal.business_email')
            ->addSettingItem('paypal', ['text', ['label' => __('ctic_admin.business_number')]], 'ctic.payment.paypal.business_number')
            ->addSettingItem('paypal', ['checkbox', ['label' => 'Sandbox']], 'ctic.payment.paypal.sandbox')
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
