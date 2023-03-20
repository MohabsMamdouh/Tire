<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\CustomerCarInfo;
use App\Models\CarModel;
use App\Models\Customer;

class CustomerCarInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = CarModel::Where('model', '01')->first();
        $customer = Customer::Where('customer_fname', 'Eslam Mamdouh')->first();

        $CustomerCarInfo = new CustomerCarInfo();
        $CustomerCarInfo->customer_id = $customer->id;
        $CustomerCarInfo->model_id = $model->id;

        $CustomerCarInfo->save();
    }
}