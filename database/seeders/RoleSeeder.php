<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            array(
                'name' => "super_admin",
                'guard_name' => 'web',
            )
        );

        DB::table('roles')->insert(
            array(
                'name' => "admin",
                'guard_name' => 'web',
            )
        );


        DB::table('roles')->insert(
            array(
                'name' => "mechanic",
                'guard_name' => 'web',
            )
        );


        DB::table('roles')->insert(
            array(
                'name' => "customer",
                'guard_name' => 'customer',
            )
        );
    }
}
