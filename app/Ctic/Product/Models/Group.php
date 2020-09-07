<?php

namespace App\Ctic\Product\Models;

use Illuminate\Database\Eloquent\Model;
use App\Ctic\Product\Contracts\Group as GroupContract;

class Group extends Model implements GroupContract
{
    protected $table = 'groups';

    protected $fillable = [
        'product_id',
        'name',
        'observation',
        'order',
        'mandatory',
        'unique_group',
        'collapsed',
    ];

    public function products()
    {
        return $this->belongsToMany('App\Ctic\Product\Models\Product');
    }

    public function isActive()
    {
        return true;
    }

    public function title()
    {
        return $this->name;
    }

    public function product()
    {
        return $this->belongsTo('App\Ctic\Product\Models\Product');
    }

    public function groupProducts()
    {
        return $this->belongsToMany('App\Ctic\Product\Models\Product', 'product_groups', 'group_id', 'product_id')->withPivot(['order', 'price', 'group_modifiable']);
    }
}
