<?php

namespace App\Http\Controllers\Admin;

use Konekt\AppShell\Http\Controllers\BaseController;
use Vanilo\Category\Models\TaxonomyProxy;
use Vanilo\Product\Contracts\Product;
use Vanilo\Product\Models\ProductProxy;
use Vanilo\Product\Models\ProductStateProxy;
use Vanilo\Framework\Contracts\Requests\CreateProduct;
use Vanilo\Framework\Contracts\Requests\UpdateProduct;
use Vanilo\Properties\Models\PropertyProxy;

class ProductController extends BaseController
{
    /**
     * Displays the product index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('vanilo::product.index', [
            'products' => ProductProxy::paginate(100)
        ]);
    }

    /**
     * Displays the create new product view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('vanilo::product.create', [
            'product' => app(Product::class),
            'states'  => ProductStateProxy::choices()
        ]);
    }

    /**
     * @param CreateProduct $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateProduct $request)
    {
        try {
            $product = ProductProxy::create($request->except('images'));
            flash()->success(__(':name has been created', ['name' => $product->name]));

            try {
                if (!empty($request->files->filter('images'))) {
                    $product->addMultipleMediaFromRequest(['images'])->each(function ($fileAdder) {
                        $fileAdder->toMediaCollection('default', env("FILESYSTEM_DRIVER", "local"));
                    });
                }
            } catch (\Exception $e) { // Here we already have the product created
                flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

                return redirect()->route('vanilo.product.edit', ['product' => $product]);
            }
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.product.index'));
    }

    /**
     * Show the product
     *
     * @param Product $product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Product $product)
    {
        $products = ProductProxy::all();
        $productsElegibleAsComplement = [];
        foreach($products as $optionComplementProduct) {
            if ($product->id === $optionComplementProduct->id) {
                continue;
            }

            $isComplementYet = false;
            foreach ($product->complementProducts as $complementProduct) {
                if ($complementProduct->id === $optionComplementProduct->id) {
                    $isComplementYet = true;
                }
            }

            if ($isComplementYet) {
                continue;
            }

            $productsElegibleAsComplement[] = $optionComplementProduct;
        }

        return view('vanilo::product.show', [
            'product'    => $product,
            'taxonomies' => TaxonomyProxy::all(),
            'properties' => PropertyProxy::all(),
            'productsElegibleAsComplement'   => $productsElegibleAsComplement,
        ]);
    }

    /**
     * @param Product $product
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('vanilo::product.edit', [
            'product'    => $product,
            'states'     => ProductStateProxy::choices()
        ]);
    }

    /**
     * Saves updates to an existing product
     *
     * @param Product       $product
     * @param UpdateProduct $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Product $product, UpdateProduct $request)
    {
        try {
            $product->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $product->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('vanilo.product.index'));
    }

    /**
     * Delete a product
     *
     * @param Product $product
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Product $product)
    {
        try {
            $name = $product->name;
            $product->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('vanilo.product.index'));
    }
}
