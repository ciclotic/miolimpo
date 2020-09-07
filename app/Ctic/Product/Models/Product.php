<?php

namespace App\Ctic\Product\Models;

use Vanilo\Framework\Models\Product as BaseProduct;

class Product extends BaseProduct
{
    const ARCHETYPES = [
        'basic',
        'multiple',
        'unique',
        'various',
        'combined',
    ];

    public function groups()
    {
        return $this->hasMany('App\Ctic\Product\Models\Group');
    }

    public function groupsAsElement()
    {
        return $this->belongsToMany('App\Ctic\Product\Models\Group', 'product_groups', 'product_id', 'group_id')->withPivot('order', 'price', 'group_modifiable');
    }

    public function complementProducts()
    {
        return $this->belongsToMany('App\Ctic\Product\Models\Product', 'complement_products', 'main_product_id', 'complement_product_id')->withPivot('selected');
    }

    public function complementOfProducts()
    {
        return $this->belongsToMany('App\Ctic\Product\Models\Product', 'complement_products', 'complement_product_id', 'main_product_id')->withPivot('selected');
    }

    public function productOfGroups()
    {
        return $this->belongsToMany('App\Ctic\Product\Models\Product', 'product_groups', 'product_id', 'group_id')->withPivot(['order', 'price', 'group_modifiable']);
    }
}
