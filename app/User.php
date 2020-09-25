<?php

namespace App;

use Laravel\Cashier\Billable;

class User extends \Konekt\AppShell\Models\User
{
    use Billable;

    protected $fillable = [
        'name', 'email', 'password', 'type', 'is_active', 'surname', 'newsletter', 'phone'
    ];

    protected $casts = [
        'newsletter'     => 'boolean',
    ];

    public function addressBooks()
    {
        return $this->hasMany('App\Ctic\AddressBook\Models\AddressBook');
    }
}
