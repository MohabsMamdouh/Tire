<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Customer;
use App\Models\User;
use App\Models\Visit;
use App\Models\CustomerCarInfo;


class VisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::Where('fname', 'Mohab Mamdouh')->first();
        $customer = Customer::Where('customer_fname', 'Eslam Mamdouh')->first();
        $CustomerCarInfo = CustomerCarInfo::Where('customer_id', $customer->id)->first();

        $visit = new Visit();
        $visit->customer_id = $customer->id;
        $visit->reason = "Fixing";
        $visit->user_id = $user->id;
        $visit->car_model_id = $CustomerCarInfo->model_id;

        $visit->save();
    }
}