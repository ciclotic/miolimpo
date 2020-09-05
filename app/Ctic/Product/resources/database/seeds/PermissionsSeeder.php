<?php

namespace App\Product\Seeds;

use Illuminate\Database\Seeder;
use Konekt\Acl\Models\Role;
use Konekt\Acl\Models\Permission;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('konekt.acl.cache');

        // create permissions
        Permission::create(['name' => 'edit groups']);
        Permission::create(['name' => 'delete groups']);
        Permission::create(['name' => 'create groups']);
        Permission::create(['name' => 'list groups']);

        // role assign existing permissions
        $role = Role::where(['name' => 'admin'])->first();
        $role->givePermissionTo('edit groups');
        $role->givePermissionTo('delete groups');
        $role->givePermissionTo('create groups');
        $role->givePermissionTo('list groups');
    }
}
