<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Cart\Contracts\CartItem;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Product\Contracts\Product;
use Vanilo\Product\Models\ProductProxy;

class CartController extends Controller
{
    protected function addCombinedProduct(Product $product, $complementProducts, $quantity)
    {
        $cartItem = Cart::addItem($product, $quantity, ['withoutOverride' => true]);

        if (is_array($complementProducts)) {
            $lastComplementProductCartItem = null;
            $lastComplementProductToCheck = null;
            foreach ($complementProducts as $complementProductId => $complementGroupId) {
                $complementProduct = ProductProxy::find($complementProductId);
                $commonAttributes = [
                    'group_id'  => $complementGroupId,
                    'cost'         => $complementProduct->cost,
                    'iva'          => $complementProduct->iva,
                ];

                // If last product without relation has current product as complement
                if ($lastComplementProductCartItem && $lastComplementProductToCheck && $lastComplementProductToCheck->complementProducts && in_array($complementProductId, $lastComplementProductToCheck->complementProducts->pluck('id')->toArray())) {
                    $price = $complementProduct->priceApplicableFromCombinedProduct($product, $lastComplementProductToCheck, $complementGroupId);
                    $linePrice = 1 * $price;
                    $ivaPrice = ($complementProduct->iva / 100) * (1 * $price);

                    Cart::addItem(
                        $complementProduct,
                        1,
                        [
                            'withoutOverride' => true,
                            'attributes' => array_merge(
                                [
                                    'parent_id' => $lastComplementProductCartItem->id,
                                    'price'        => $price,
                                    'line_price'   => $linePrice,
                                    'iva_price'    => $ivaPrice,
                                ],
                                $commonAttributes
                            )
                        ]
                    );
                } else {
                    $price = $complementProduct->priceApplicableFromCombinedProduct($product, $complementProduct, $complementGroupId);
                    $linePrice = 1 * $price;
                    $ivaPrice = ($complementProduct->iva / 100) * (1 * $price);

                    $lastComplementProductToCheck = $complementProduct;

                    $lastComplementProductCartItem = Cart::addItem(
                        $complementProduct,
                        1,
                        [
                            'withoutOverride' => true,
                            'attributes' => array_merge(
                                [
                                    'parent_id' => $cartItem->id,
                                    'price'        => $price,
                                    'line_price'   => $linePrice,
                                    'iva_price'    => $ivaPrice,
                                ],
                                $commonAttributes
                            )
                        ]
                    );
                }
            }
        }
    }

    public function add(Product $product, Request $request)
    {
        $complementProducts = $request->get('products-to-complements-selected', []);
        $quantity = $request->get('quantity', 1);

        if ($product->archetype && \App\Ctic\Product\Models\Product::ARCHETYPES[$product->archetype] === 'combined') { // Combined
            $this->addCombinedProduct($product, $complementProducts, $quantity);
        } else {
            if (!is_array($complementProducts) && $complementProducts) { // Unique
                Cart::addItem(ProductProxy::find($complementProducts), $quantity, ['withoutOverride' => true]);
            } else {
                $cartItem = Cart::addItem($product, $quantity, ['withoutOverride' => true]); // Basic

                if (is_array($complementProducts)) { // Multiple
                    foreach ($complementProducts as $complementProductId => $complementProductValue) {
                        Cart::addItem(ProductProxy::find($complementProductId), $quantity, ['withoutOverride' => true, 'attributes' => ['parent_id' => $cartItem->id]]);
                    }
                }
            }
        }

        flash()->success(__( 'ctic_shop.has_been_added', ['name' => $product->name]));

        return redirect()->route('product.index', ['show-cart' => true]);
    }

    public function remove(CartItem $cart_item)
    {
        Cart::removeItem($cart_item);
        flash()->info(__('ctic_shop.has_been_removed', ['name' => $cart_item->getBuyable()->getName()]));

        return redirect()->route('product.index', ['show-cart' => true]);
    }

    public function update(CartItem $cart_item, Request $request)
    {
        $qty = (int) $request->get('qty', $cart_item->getQuantity());
        $cart_item->quantity = $qty;
        $cart_item->save();

        flash()->info(__('ctic_shop.has_been_updated', ['name' => $cart_item->getBuyable()->getName()]));

        return redirect()->route('product.index', ['show-cart' => true]);
    }

    public function show()
    {
        return view('cart.show', $this->getCommonParameters());
    }
}
