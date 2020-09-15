<?php

namespace App\Ctic\Cart\Models;

use Vanilo\Cart\Models\CartItem as CartItemBase;

class CartItem extends CartItemBase
{

    public function parent()
    {
        return $this->belongsTo('App\Ctic\Cart\Models\CartItem');
    }

    public function group()
    {
        return $this->belongsTo('App\Ctic\Product\Models\Group');
    }

    public function children()
    {
        return $this->hasMany('App\Ctic\Cart\Models\CartItem', 'parent_id');
    }

}
