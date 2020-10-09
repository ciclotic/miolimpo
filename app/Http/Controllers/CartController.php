<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Cart\Contracts\CartItem;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Product\Contracts\Product;
use Vanilo\Product\Models\ProductProxy;

class CartController extends Controller
{
    protected function addVariousProduct(Product $product, $complementProducts, $quantity)
    {
        if (is_array($complementProducts)) {
            foreach ($complementProducts as $complementProductId => $complementProductValue) {
                $quantityComplement = (empty($quantity[$complementProductId])) ? 0 : $quantity[$complementProductId];
                if ($quantityComplement) {
                    Cart::addItem(ProductProxy::find($complementProductId), $quantityComplement, ['withoutOverride' => true]);
                }
            }
        }
    }

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
        } elseif ($product->archetype && \App\Ctic\Product\Models\Product::ARCHETYPES[$product->archetype] === 'various') { // Various
            $quantity = $request->get('quantity-complement', 1);
            $this->addVariousProduct($product, $complementProducts, $quantity);
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

        $url = url()->previous();
        if (str_contains($url, '?')) {
            $url .= '&show-cart=true';
        } else {
            $url .= '?show-cart=true';
        }
        return redirect()->to($url);
    }

    public function remove(CartItem $cart_item)
    {
        foreach ($cart_item->children as $cartItemProduct) {
            foreach ($cartItemProduct->children as $cartItemComplement) {
                Cart::removeItem($cartItemComplement);
            }

            Cart::removeItem($cartItemProduct);
        }
        Cart::removeItem($cart_item);
        flash()->info(__('ctic_shop.has_been_removed', ['name' => $cart_item->getBuyable()->getName()]));

        $url = url()->previous();
        if (str_contains($url, '?')) {
            $url .= '&show-cart=true';
        } else {
            $url .= '?show-cart=true';
        }
        return redirect()->to($url);
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
