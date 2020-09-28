<?php

use Illuminate\Database\Seeder;
use Konekt\Acl\Models\Permission;
use Konekt\Acl\Models\Role;

class ShippingMethodPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('konekt.acl.cache');

        // create permissions
        Permission::create(['name' => 'edit shipping_methods']);
        Permission::create(['name' => 'delete shipping_methods']);
        Permission::create(['name' => 'create shipping_methods']);
        Permission::create(['name' => 'list shipping_methods']);

        // role assign existing permissions
        $role = Role::where(['name' => 'admin'])->first();
        $role->givePermissionTo('edit shipping_methods');
        $role->givePermissionTo('delete shipping_methods');
        $role->givePermissionTo('create shipping_methods');
        $role->givePermissionTo('list shipping_methods');
    }
}
