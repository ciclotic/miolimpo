<?php

namespace App\Ctic\Order\Factories;

use Vanilo\Contracts\Buyable;
use Vanilo\Contracts\CheckoutSubject;
use Vanilo\Framework\Factories\OrderFactory as BaseOrderFactory;
use Vanilo\Order\Contracts\Order;

class OrderFactory extends BaseOrderFactory
{

    /**
     * Returns whether an instance contains a buyable object
     *
     * @param array $item
     *
     * @return bool
     */
    protected function itemContainsABuyableProtected(array $item)
    {
        return isset($item['product']) && $item['product'] instanceof Buyable;
    }

    /**
     * Creates a single item for the given order
     *
     * @param Order $order
     * @param array $item
     */
    protected function createItem(Order $order, array $item)
    {
        if ($this->itemContainsABuyableProtected($item)) {
            $cartItem = $item['cart_item'];
            $item    = array_merge($item, [
                'product_type' => $cartItem->product_type,
                'product_id'   => $cartItem->product_id,
                'price'        => $cartItem->price,
                'name'         => $item['product']->name,
            ]);
            unset($item['product']);
        }

        $order->items()->create($item);
    }

    protected function convertCartItemsToDataArray(CheckoutSubject $cart)
    {
        return $cart->getItems()->map(function ($item) {
            return [
                'cart_item'  => $item,
                'product'  => $item->getBuyable(),
                'quantity' => $item->getQuantity()
            ];
        })->all();
    }
}
