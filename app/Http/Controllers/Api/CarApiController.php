<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\CarController;


class CarApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::with('models')->get();

        return [
            'status' => 1,
            'data' => $cars
        ];

    }

    public function UpdateCarsFromAPIToDB()
    {

        $api_url = 'https://public.opendatasoft.com/api/records/1.0/search/?dataset=all-vehicles-model&q=&rows=10000&sort=modifiedon&facet=make&facet=model&facet=cylinders&facet=drive&facet=eng_dscr&facet=fueltype&facet=fueltype1&facet=mpgdata&facet=phevblended&facet=trany&facet=vclass&facet=year';

        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        (new CarController)->StoreCarName($response_data->records);

        // $this->StoreCarName($response_data->records);

        (new CarController)->storeModelsSpecs($response_data->records);

        // $this->storeModelsSpecs($response_data->records);

        return [
            'status' => 1,
            // 'data' => $response_data->records,
            'msg' => 'updated successfully'
        ];
    }


    public function searchCar(Request $request)
    {
        $output = '';
        $q = $request->get('query');
        if($q != '')
        {
            $data = Car::where('car_name', 'like', '%'.$q.'%')
                        ->get();
        } else {
            $data = Car::with('models')->get();
        }

        return [
            'status' => 1,
            'data' => $data
        ];
    }

    public function getCarModels(Request $request)
    {
        $output = "<option value=''>-- ".__('Chooce The Model')." --</option>";
        $carmodels = Car::with('models')->where('car_name', $request->get('query'))->first();

        return [
            'status' => 1,
            'data' => $carModels
        ];
    }

    public function getCarSpecs(Request $request)
    {
        $output = "";
        $carSpecs = CarModel::with('car')->where('model', $request->get('model'))->first();

        return [
            'status' => 1,
            'data' => $carSpecs
        ];
    }
}
