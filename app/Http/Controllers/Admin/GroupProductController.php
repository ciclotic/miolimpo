<?php

namespace App\Http\Controllers\Admin;

use App\Ctic\Product\Contracts\Group;
use App\Ctic\Product\Models\GroupProxy;
use App\Http\Controllers\Controller;
use Vanilo\Product\Contracts\Product;

class GroupProductController extends Controller
{
    public function store(Group $group, $group_product, $order_field, $price, bool $group_modifiable)
    {
        try {
            $group->groupProducts()->attach($group_product, ['order' => $order_field, 'price' => $price, 'group_modifiable' => $group_modifiable]);

        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return response()->json('product of group added');
    }

    public function update(Group $group, $group_product, $order_field, $price, bool $group_modifiable)
    {
        try {
            $group = GroupProxy::find($group);
            $group->groupProducts()->updateExistingPivot($group_product, ['order' => $order_field, 'price' => $price, 'group_modifiable' => $group_modifiable]);

        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return response()->json('product of group updated');
    }

    public function remove(Group $group, $group_product)
    {
        try {
            $group->groupProducts()->detach($group_product);

        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return response()->json('product of group deleted');
    }
}
