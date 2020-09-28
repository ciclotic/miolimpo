<?php

namespace App\Http\Controllers\Admin;

use Konekt\AppShell\Http\Controllers\BaseController;
use App\Ctic\ShippingMethod\Http\Requests\CreateShippingMethod;
use App\Ctic\ShippingMethod\Http\Requests\UpdateShippingMethod;
use App\Ctic\ShippingMethod\Contracts\ShippingMethod;
use App\Ctic\ShippingMethod\Models\ShippingMethodProxy;

class ShippingMethodController extends BaseController
{
    public function index()
    {
        return view('admin.shipping_method.index', [
            'shipping_methods' => ShippingMethodProxy::paginate(100)
        ]);
    }

    public function create()
    {

        return view('admin.shipping_method.create', [
            'shipping_method'     => app(ShippingMethod::class),
        ]);
    }

    public function store(CreateShippingMethod $request)
    {
        try {
            $shipping_method = ShippingMethodProxy::create($request->all());
            flash()->success(__(':name has been created', ['name' => $shipping_method->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('admin.shipping_method.edit', $shipping_method));
    }

    public function show(ShippingMethod $shipping_method)
    {
        return view('admin.shipping_method.show', [
            'shipping_method' => $shipping_method,
        ]);
    }

    public function edit(ShippingMethod $shipping_method)
    {
        return view('admin.shipping_method.edit', [
            'shipping_method' => $shipping_method,
        ]);
    }

    public function update(ShippingMethod $shipping_method, UpdateShippingMethod $request)
    {
        try {
            $shipping_method->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $shipping_method->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('admin.shipping_method.index'));
    }

    public function destroy(ShippingMethod $shipping_method)
    {
        try {
            $name = $shipping_method->name;
            $shipping_method->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('admin.shipping_method.index'));
    }
}
