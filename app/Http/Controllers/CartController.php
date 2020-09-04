<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Vanilo\Cart\Contracts\CartItem;
use Vanilo\Cart\Facades\Cart;
use Vanilo\Product\Contracts\Product;
use Vanilo\Product\Models\ProductProxy;

class CartController extends Controller
{
    public function add(Product $product, Request $request)
    {
        $complementProducts = $request->get('products-to-complements-selected', []);
        $quantity = $request->get('quantity', 1);

        if (! is_array($complementProducts) && $complementProducts) {
            Cart::addItem(ProductProxy::find($complementProducts), $quantity);
        } else {
            Cart::addItem($product, $quantity);

            if (is_array($complementProducts)) {
                foreach ($complementProducts as $complementProductId => $complementProductValue) {
                    Cart::addItem(ProductProxy::find($complementProductId), $quantity);
                }
            }
        }

        flash()->success($product->name . ' has been added to cart');

        return redirect()->route('cart.show', $this->getCommonParameters());
    }

    public function remove(CartItem $cart_item)
    {
        Cart::removeItem($cart_item);
        flash()->info($cart_item->getBuyable()->getName() . ' has been removed from cart');

        return redirect()->route('cart.show', $this->getCommonParameters());
    }

    public function update(CartItem $cart_item, Request $request)
    {
        $qty = (int) $request->get('qty', $cart_item->getQuantity());
        $cart_item->quantity = $qty;
        $cart_item->save();

        flash()->info($cart_item->getBuyable()->getName() . ' has been updated');

        return redirect()->route('cart.show', $this->getCommonParameters());
    }

    public function show()
    {
        return view('cart.show', $this->getCommonParameters());
    }
}
