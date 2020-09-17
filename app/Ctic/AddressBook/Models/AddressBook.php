<?php

namespace App\Ctic\AddressBook\Models;

use Illuminate\Database\Eloquent\Model;
use App\Ctic\AddressBook\Contracts\AddressBook as AddressBookContract;

class AddressBook extends Model implements AddressBookContract
{
    protected $table = 'address_books';

    protected $fillable = [
        'user_id',
        'name',
        'addressee_name',
        'addressee_surname',
        'address',
        'address2',
        'postal_code',
        'town',
        'phone',
    ];

    public function isActive()
    {
        return true;
    }

    public function title()
    {
        return $this->name;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function groupProducts()
    {
        return $this->belongsToMany('App\Ctic\Product\Models\Product', 'product_groups', 'group_id', 'product_id')->withPivot(['order', 'price', 'group_modifiable']);
    }
}
