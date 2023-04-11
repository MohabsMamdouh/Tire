<?php

namespace App\Traits;

use Illuminate\Http\Request;

// Models
use App\Models\Car;
use App\Models\CarModel;


/**
 * Function fot storing car and its models and specs in db
 */
trait CarsTrait
{
    public $UrlAPi = 'https://public.opendatasoft.com/api/records/1.0/search/?dataset=all-vehicles-model&q=&rows=10000&sort=modifiedon&facet=make&facet=model&facet=cylinders&facet=drive&facet=eng_dscr&facet=fueltype&facet=fueltype1&facet=mpgdata&facet=phevblended&facet=trany&facet=vclass&facet=year';

    public function StoreCarName($cars)
    {
        foreach ($cars as $car) {
            $c = Car::where('car_name', $car->fields->make)->get();
            if(count($c) != 0) {
                continue;
            }

            $new_car = new Car();
            $new_car->car_name = $car->fields->make;
            $new_car->save();
        }
    }

    public function storeModelsSpecs($specs)
    {
        foreach ($specs as $spec) {
            $check = CarModel::where('model', $spec->fields->model)->get();
            if(count($check) != 0){
                continue;
            }
            $mod = new CarModel();
            if (isset($spec->fields->model)) {
                $mod->model = $spec->fields->model;
            }

            if (isset($spec->fields->cylinders)) {
                $mod->cylinders = $spec->fields->cylinders;
            }

            if (isset($spec->fields->drive)) {
                $mod->drive = $spec->fields->drive;
            }

            if (isset($spec->fields->eng_dscr)) {
                $mod->eng_dscr = $spec->fields->eng_dscr;
            }

            if (isset($spec->fields->fueltype)) {
                $mod->fueltype = $spec->fields->fueltype;
            }

            if (isset($spec->fields->fueltype1)) {
                $mod->fueltype1 = $spec->fields->fueltype1;
            }

            if (isset($spec->fields->mpgdata)) {
                $mod->mpgdata = $spec->fields->mpgdata;
            }

            if (isset($spec->fields->phevblended)) {
                $mod->phevblended = $spec->fields->phevblended;
            }

            $car = Car::where('car_name', '=', $spec->fields->make)->first();
            $mod->car_id = $car->id;

            $mod->save();
        }
    }
}