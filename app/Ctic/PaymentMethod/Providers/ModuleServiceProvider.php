<?php

namespace App\Ctic\PaymentMethod\Providers;

use App\Ctic\PaymentMethod\Models\PaymentMethod;
use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        PaymentMethod::class
    ];
}
