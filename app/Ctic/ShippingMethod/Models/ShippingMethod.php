<?php

namespace App\Ctic\ShippingMethod\Models;

use Illuminate\Database\Eloquent\Model;
use App\Ctic\ShippingMethod\Contracts\ShippingMethod as ShippingMethodContract;

class ShippingMethod extends Model implements ShippingMethodContract
{
    protected $table = 'shipping_methods';

    protected $fillable = [
        'name',
        'observation',
        'order',
        'gateway',
    ];

    public function isActive()
    {
        return true;
    }

    public function title()
    {
        return $this->name;
    }
}
