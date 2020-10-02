<?php

namespace App\Ctic\Cart\Models;

use App\Ctic\ShippingMethod\Contracts\ShippingMethod;
use \Vanilo\Cart\Models\Cart as CartBase;
use Vanilo\Contracts\Buyable;

class Cart extends CartBase
{
    /**
     * @inheritDoc
     */
    public function addItem(Buyable $product, $qty = 1, $params = []): \Vanilo\Cart\Contracts\CartItem
    {
        $item = $this->items()->ofCart($this)->byProduct($product)->first();

        if ($item && empty($params['withoutOverride'])) {
            $item->quantity += $qty;
            $item->line_price = $item->quantity * $product->getPrice();
            $item->iva_price = ($product->iva / 100) * ($item->quantity * $product->getPrice());
            $item->save();
        } else {
            $item = $this->items()->create(
                array_merge(
                    $this->getDefaultCartItemAttributes($product, $qty),
                    $this->getExtraProductMergeAttributes($product),
                    $params['attributes'] ?? []
            )
            );
        }


        $this->load('items');

        return $item;
    }

    /**
     * Returns the default attributes of a Buyable for a cart item
     *
     * @param Buyable $product
     * @param integer $qty
     *
     * @return array
     */
    protected function getDefaultCartItemAttributes(Buyable $product, $qty)
    {
        // TODO integrate parent_id, group_id and note
        // $table->integer('parent_id')->nullable();
        // $table->integer('group_id')->nullable();
        // $table->string('note')->nullable();
        return [
            'product_type' => $product->morphTypeName(),
            'product_id'   => $product->getId(),
            'quantity'     => $qty,
            'price'        => $product->getPrice(),
            'line_price'   => $qty * $product->getPrice(),
            'cost'         => $product->cost,
            'iva'          => $product->iva,
            'iva_price'    => ($product->iva / 100) * ($qty * $product->getPrice()),
        ];
    }
}
