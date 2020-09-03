<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Ctic\Product\Models\Product;

class ComplementController extends Controller
{
    public function store($mainProduct, $complementProduct, bool $selected)
    {
        try {
            $product = Product::find($mainProduct);
            $product->complementProducts()->attach($complementProduct, ['selected' => $selected]);

        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return response()->json('complement added');
    }

    public function update($mainProduct, $complementProduct, bool $selected)
    {
        try {
            $product = Product::find($mainProduct);
            $product->complementProducts()->updateExistingPivot($complementProduct, ['selected' => $selected]);

        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return response()->json('complement updated');
    }

    public function remove($mainProduct, $complementProduct)
    {
        try {
            $product = Product::find($mainProduct);
            $product->complementProducts()->detach($complementProduct);

        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return response()->json('complement deleted');
    }
}
