<?php

namespace App\Ctic\Product\Providers;

use App\Ctic\Product\Models\Group;
use Konekt\Concord\BaseModuleServiceProvider;

class ModuleServiceProvider extends BaseModuleServiceProvider
{
    protected $models = [
        Group::class
    ];
}
