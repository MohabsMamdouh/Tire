<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = Role::create(['name' => 'super_admin']);
        $role->givePermissionTo(Permission::all());


        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'mechanic']);
        $role->givePermissionTo([
            'show users',
            'show customers',
            'create customer',
            'show customer',
            'add customer car',
            'show visits',
            'create visit',
            'edit visit',
            'delete visit',
            'show feedbacks',
            'accept feedback',
            'delete feedback',
            'store location',
        ]);

        $role = Role::create(['name' => 'customer', 'guard_name' => 'customer']);
        // $role->givePermissionTo(Permission::all());
    }
}
