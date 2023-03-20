<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\CustomerCarInfo;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;



class CarController extends Controller
{

    private function StoreCarName($cars)
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

    private function storeModelsSpecs($specs)
    {
        foreach ($specs as $spec ) {
            $check = CarModel::where('model', $spec->fields->model)->get();
            if(count($check) != 0){
                continue;
            }
            $mod = new CarModel();
            if (!isset($spec->fields->model)) {
                $mod->model = "-";
            } else {
                $mod->model = $spec->fields->model;
            }

            if (!isset($spec->fields->cylinders)) {
                $mod->cylinders = "-";
            } else {
                $mod->cylinders = $spec->fields->cylinders;
            }

            if (!isset($spec->fields->drive)) {
                $mod->drive = "-";
            } else {
                $mod->drive = $spec->fields->drive;
            }

            if (!isset($spec->fields->eng_dscr)) {
                $mod->eng_dscr = "-";
            } else {
                $mod->eng_dscr = $spec->fields->eng_dscr;
            }

            if (!isset($spec->fields->fueltype)) {
                $mod->fueltype = "-";
            } else {
                $mod->fueltype = $spec->fields->fueltype;
            }

            if (!isset($spec->fields->fueltype1)) {
                $mod->fueltype1 = "-";
            } else {
                $mod->fueltype1 = $spec->fields->fueltype1;
            }

            if (!isset($spec->fields->mpgdata)) {
                $mod->mpgdata = "-";
            } else {
                $mod->mpgdata = $spec->fields->mpgdata;
            }

            if (!isset($spec->fields->phevblended)) {
                $mod->phevblended = "-";
            } else {
                $mod->phevblended = $spec->fields->phevblended;
            }

            $car = Car::where('car_name', '=', $spec->fields->make)->first();
            $mod->car_id = $car->id;

            $mod->save();
        }
    }

    public function UpdateCarsFromAPIToDB()
    {

        $api_url = 'https://public.opendatasoft.com/api/records/1.0/search/?dataset=all-vehicles-model&q=&rows=10000&sort=modifiedon&facet=make&facet=model&facet=cylinders&facet=drive&facet=eng_dscr&facet=fueltype&facet=fueltype1&facet=mpgdata&facet=phevblended&facet=trany&facet=vclass&facet=year';

        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        $this->StoreCarName($response_data->records);

        $this->storeModelsSpecs($response_data->records);

        return redirect()->route('car.showAll');
    }

    public function showAll() // Done
    {
        $cars = Car::with('models')->take(5)->get();

        $data = [
            'cars' => $cars,
            'title' => 'Show all cars'
        ];

        return view('cars.show', $data);
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

        $total_row = count($data);
        if($total_row > 0)
        {
            $output .= '<tr>';

            foreach($data as $car)
            {
                foreach ($car->models as $model) {
                    $output .= '<tr>';
                    $output .= '<td class="border px-2 py-2">'.$car->car_name.'</td>';

                    $output .='
                        <td class="border px-2 py-2">'.$model->model.'</td>
                        <td class="border px-2 py-2">'.$model->cylinders.'</td>
                        <td class="border px-2 py-2">'.$model->drive.'</td>
                        <td class="border px-2 py-2">'.$model->eng_dscr.'</td>
                        <td class="border px-2 py-2">'.$model->fueltype.'</td>
                        <td class="border px-2 py-2">'.$model->fueltype1.'</td>
                        <td class="border px-2 py-2">'.$model->mpgdata.'</td>
                        <td class="border px-2 py-2">'.$model->phevblended.'</td>
                    ';
                    $output .= '</tr>';
                }
            }
        } else {
            $output = '
            <tr>
                <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }
        $data = array(
            'table_data'  => $output,
        );

        foreach ($data as $d) {
            echo $d;
        }
    }

    public function getCarModels(Request $request)
    {
        $output = "<option value=''>-- ".__('Chooce The Model')." --</option>";
        $car = Car::with('models')->where('car_name', $request->get('query'))->first();

        foreach ($car->models as $model) {
            $output .='<option value="'.$model->model.'">'.$model->model.'</option>';
        }

        $data = array(
            'table_data'  => $output,
        );

        foreach ($data as $d) {
            echo $d;
        }
    }

    public function getCarSpecs(Request $request)
    {
        $output = "";
        $model = CarModel::with('car')->where('model', $request->get('model'))->first();
        $output .= '
            <div class="font-bold text-xl mb-2">'. $model->car->car_name .'</div>
            <p class="text-gray-700 text-base">
                Model: '.$model->model.'<br>
                Cylinders: '.$model->cylinders.'<br>
                Drive: '.$model->drive.'<br>
                fueltype: '.$model->fueltype.'<br>
                fueltype: '.$model->fueltype1.'
            </p>';

        $data = array(
            'table_data'  => $output,
        );

        foreach ($data as $d) {
            echo $d;
        }
    }

}
