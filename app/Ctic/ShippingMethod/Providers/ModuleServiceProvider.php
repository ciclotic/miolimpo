<?php

namespace App\Ctic\ShippingMethod\Providers;

use App\Ctic\ShippingMethod\Models\ShippingMethod;
use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        ShippingMethod::class
    ];
}
