<?php

namespace App\Http\Controllers\Admin;

use Konekt\AppShell\Http\Controllers\BaseController;
use App\Ctic\Product\Http\Requests\CreateGroup;
use App\Ctic\Product\Http\Requests\UpdateGroup;
use App\Ctic\Product\Contracts\Group;
use App\Ctic\Product\Models\GroupProxy;
use Vanilo\Product\Models\ProductProxy;

class GroupController extends BaseController
{
    public function index()
    {
        return view('admin.group.index', [
            'groups' => GroupProxy::paginate(100)
        ]);
    }

    public function create()
    {
        $products = ProductProxy::all();

        return view('admin.group.create', [
            'products'  => $products,
            'group'     => app(Group::class),
        ]);
    }

    public function store(CreateGroup $request)
    {
        try {
            $group = GroupProxy::create($request->all());
            flash()->success(__(':name has been created', ['name' => $group->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('admin.group.edit', $group));
    }

    public function show(Group $group)
    {
        return view('admin.group.show', [
            'group' => $group,
        ]);
    }

    public function edit(Group $group)
    {
        $products = ProductProxy::all();
        $productsElegibleAsGroupProduct = [];
        foreach($products as $optionGroupProductProduct) {

            $isGroupProductYet = false;
            foreach ($group->groupProducts as $groupProductProduct) {
                if ($groupProductProduct->id === $optionGroupProductProduct->id) {
                    $isGroupProductYet = true;
                }
            }

            if ($isGroupProductYet) {
                continue;
            }

            $productsElegibleAsGroupProduct[] = $optionGroupProductProduct;
        }

        return view('admin.group.edit', [
            'group' => $group,
            'products'                         => $products,
            'productsElegibleAsGroupProduct'   => $productsElegibleAsGroupProduct,
        ]);
    }

    public function update(Group $group, UpdateGroup $request)
    {
        try {
            $group->update($request->all());

            flash()->success(__(':name has been updated', ['name' => $group->name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back()->withInput();
        }

        return redirect(route('admin.group.index'));
    }

    public function destroy(Group $group)
    {
        try {
            $name = $group->name;
            $group->delete();

            flash()->warning(__(':name has been deleted', ['name' => $name]));
        } catch (\Exception $e) {
            flash()->error(__('Error: :msg', ['msg' => $e->getMessage()]));

            return redirect()->back();
        }

        return redirect(route('admin.group.index'));
    }
}
