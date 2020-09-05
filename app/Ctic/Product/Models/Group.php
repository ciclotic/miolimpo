<?php

namespace App\Ctic\Product\Models;

use Illuminate\Database\Eloquent\Model;
use App\Ctic\Product\Contracts\Group as GroupContract;

class Group extends Model implements GroupContract
{
    protected $table = 'groups';

    protected $fillable = [
        'name'
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
}
