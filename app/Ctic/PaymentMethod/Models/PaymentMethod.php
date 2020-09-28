<?php

namespace App\Ctic\PaymentMethod\Models;

use Illuminate\Database\Eloquent\Model;
use App\Ctic\PaymentMethod\Contracts\PaymentMethod as PaymentMethodContract;

class PaymentMethod extends Model implements PaymentMethodContract
{
    protected $table = 'payment_methods';

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
