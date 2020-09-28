<?php
/**
 * Contains the Order model class.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-11-27
 *
 */

namespace App\Ctic\Order\Models;

use Vanilo\Order\Models\Order as BaseOrder;

class Order extends BaseOrder
{
    public function paymentMethod()
    {
        return $this->belongsTo('App\Ctic\PaymentMethod\Models\PaymentMethod');
    }

    public function shippingMethod()
    {
        return $this->belongsTo('App\Ctic\ShippingMethod\Models\ShippingMethod');
    }
}
