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
        $user = new User();
        $user->fname = "Mohab Mamdouh";
        $user->username = 'mohabmamdouh';
        $user->email = "mohab@info.com";
        $user->password = 'M01090483647';
        $user->phone = "01156047032";
        $user->save();
        $user->assignRole('super_admin');


        $user = new User();
        $user->fname = "Rabia Mohamed";
        $user->username = 'rabiamohamed';
        $user->email = "rabia@info.com";
        $user->password = 'M01090483647';
        $user->phone = "01090483647";
        $user->save();
        $user->assignRole('admin');

    }
}