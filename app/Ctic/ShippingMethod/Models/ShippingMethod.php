<?php

namespace App\Ctic\ShippingMethod\Models;

use Illuminate\Database\Eloquent\Model;
use App\Ctic\ShippingMethod\Contracts\ShippingMethod as ShippingMethodContract;
use Vanilo\Contracts\Buyable;
use Vanilo\Support\Traits\BuyableModel;

class ShippingMethod extends Model implements ShippingMethodContract, Buyable
{
    use BuyableModel;

    protected $table = 'shipping_methods';

    protected $fillable = [
        'name',
        'observation',
        'price',
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

    public function name()
    {
        return $this->name();
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function morphTypeName(): string
    {
        return static::class;
    }

    public function hasImage()
    {
        return false;
    }

    public function getThumbnailUrl()
    {
        return null;
    }

    public function getImageUrl()
    {
        return null;
    }
}
