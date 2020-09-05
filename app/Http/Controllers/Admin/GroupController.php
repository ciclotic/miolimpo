<?php

namespace App\Http\Controllers\Admin;

use Konekt\AppShell\Http\Controllers\BaseController;
use App\Ctic\Product\Http\Requests\CreateGroup;
use App\Ctic\Product\Http\Requests\UpdateGroup;
use App\Ctic\Product\Contracts\Group;
use App\Ctic\Product\Models\GroupProxy;

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
        return view('admin.group.create', [
            'group' => app(Group::class),
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

        return redirect(route('admin.group.index'));
    }

    public function show(Group $group)
    {
        return view('admin.group.show', ['group' => $group]);
    }

    public function edit(Group $group)
    {
        return view('admin.group.edit', [
            'group' => $group,
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
