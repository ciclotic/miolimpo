<?php

namespace App\Http\Controllers\Admin;

use Konekt\AppShell\Http\Controllers\BaseController;
use App\Ctic\PaymentMethod\Http\Requests\CreatePaymentMethod;
use App\Ctic\PaymentMethod\Http\Requests\UpdatePaymentMethod;
use App\Ctic\PaymentMethod\Contracts\PaymentMethod;
use App\Ctic\PaymentMethod\Models\PaymentMethodProxy;

class PaymentMethodController extends BaseController
{
    public function index()
    {
        return view('admin.payment_method.index', [
            'payment_methods' => PaymentMethodProxy::paginate(100)
        ]);
    }

    public function create()
    {

        return view('admin.payment_method.create', [
            'payment_method'     => app(PaymentMethod::class),
        ]);
    }

    public function store(CreatePaymentMethod $request)
    {
        try {
            $payment_method = PaymentMethodProxy::create($request->all());
            flash()->success(__(':name has been created', ['name' => $payment_method->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('admin.payment_method.edit', $payment_method));
    }

    public function show(PaymentMethod $payment_method)
    {
        return view('admin.payment_method.show', [
            'payment_method' => $payment_method,
        ]);
    }

    public function edit(PaymentMethod $payment_method)
    {
        return view('admin.payment_method.edit', [
            'payment_method' => $payment_method,
        ]);
    }

    public function update(PaymentMethod $payment_method, UpdatePaymentMethod $request)
    {
        try {
            $payment_method->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $payment_method->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('admin.payment_method.index'));
    }

    public function destroy(PaymentMethod $payment_method)
    {
        try {
            $name = $payment_method->name;
            $payment_method->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('admin.payment_method.index'));
    }
}
