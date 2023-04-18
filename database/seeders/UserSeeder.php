<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User(); // Let's see
        $user->fname = "super admin";
        $user->username = "super_admin";
        $user->email = "super_admin@info.com";
        $user->password = "password";
        $user->phone = "01234564797";
        $user->save();
        $user->roles()->attach(Role::Where('name', 'super_admin')->first());

        User::factory()
            ->count(5)
            ->create();
    }
}
