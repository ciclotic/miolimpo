<?php

namespace App;

class User extends \Konekt\AppShell\Models\User
{
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
