<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $customer = new Customer();
        $customer->customer_fname = "Eslam Mamdouh";
        $customer->customer_username = 'eslammamdouh';
        $customer->customer_address = "El-Slam";
        $customer->password = 'M01090483647';
        $customer->customer_phone = "01090483647";
        $customer->email = "eslam@info.eg";
        $customer->save();
        $customer->assignRole('customer');
    }
}
