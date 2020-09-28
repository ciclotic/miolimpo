<?php

use Illuminate\Database\Seeder;
use Konekt\Acl\Models\Permission;
use Konekt\Acl\Models\Role;

class PaymentMethodPermissionsSeeder extends Seeder
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
        Permission::create(['name' => 'edit payment_methods']);
        Permission::create(['name' => 'delete payment_methods']);
        Permission::create(['name' => 'create payment_methods']);
        Permission::create(['name' => 'list payment_methods']);

        // role assign existing permissions
        $role = Role::where(['name' => 'admin'])->first();
        $role->givePermissionTo('edit payment_methods');
        $role->givePermissionTo('delete payment_methods');
        $role->givePermissionTo('create payment_methods');
        $role->givePermissionTo('list payment_methods');
    }
}
