<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\CarModel;
use App\Models\Car;


class CarModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $car = Car::Where('car_name', 'Tesla')->first();

        $model = new CarModel();
        $model->model = "01";
        $model->car_id = $car->id;

        $model->save();
    }
}