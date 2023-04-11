<?php

namespace App\Http\Controllers;

// Models
use App\Models\Customer;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\CustomerCarInfo;

// Requests
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;

// Traits
use App\Traits\CarsTrait;

// others
use Illuminate\Support\Facades\DB;


class CarController extends Controller
{
    use CarsTrait;

    public function UpdateCarsFromAPIToDB()
    {

        $api_url = $this->UrlAPi;

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