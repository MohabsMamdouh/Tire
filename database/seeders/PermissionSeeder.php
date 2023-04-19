<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'show roles']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'assign permission to role']);
        Permission::create(['name' => 'assign permission']);
        Permission::create(['name' => 'delete role']);


        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'show single user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);


        Permission::create(['name' => 'show customers']);
        Permission::create(['name' => 'create customer']);
        Permission::create(['name' => 'show customer']);
        Permission::create(['name' => 'update customer']);
        Permission::create(['name' => 'delete customer']);
        Permission::create(['name' => 'reset customer password']);


        Permission::create(['name' => 'update cars']);
        Permission::create(['name' => 'add customer car']);
        Permission::create(['name' => 'delete customer car']);


        Permission::create(['name' => 'show visits']);
        Permission::create(['name' => 'create visit']);
        Permission::create(['name' => 'edit visit']);
        Permission::create(['name' => 'delete visit']);


        Permission::create(['name' => 'show feedbacks']);
        Permission::create(['name' => 'accept feedback']);
        Permission::create(['name' => 'create feedback']);
        Permission::create(['name' => 'delete feedback']);


        Permission::create(['name' => 'store location']);

    }
}
