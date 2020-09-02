<?php

namespace App\Ctic\Product\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    public function products()
    {
        return $this->belongsToMany('App\Ctic\Product\Models\Product');
    }
}
