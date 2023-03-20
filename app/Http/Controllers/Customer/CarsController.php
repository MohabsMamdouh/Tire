<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\CustomerCarInfo;

use App\Http\Controllers\CarController;


class CarsController extends Controller
{
    public function index()
    {
        $cars = DB::table('car_models')
                ->join('customer_car_infos', 'customer_car_infos.model_id', '=', 'car_models.id')
                ->join('cars', 'cars.id', '=', 'car_models.car_id')
                ->join('customers', 'customers.id', '=', 'customer_car_infos.customer_id')
                ->select('cars.*', 'car_models.*', 'car_models.id as model_id')
                ->where('customers.id', Auth::guard('customer')->user()->id)
                ->get();

        $data = [
            'cars' => $cars,
            'title' => 'My Cars'
        ];

        return view('customer.cars.show', $data);
    }

    public function create()
    {
        $cars = Car::with('models')->orderBy('car_name')->get();

        $data = [
            'cars' => $cars,
            'title' => 'Add Car',
        ];

        return view('customer.cars.form', $data);
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

    public function store(Request $request)
    {
        $model = CarModel::where('model', $request['models'])->first();


        $customerCarInfo = new CustomerCarInfo();

        $customerCarInfo->model_id = $model->id;
        $customerCarInfo->customer_id = Auth::guard('customer')->user()->id;

        $customerCarInfo->save();

        return redirect()->route('customer.cars.show');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($model_id)
    {
        return (new CarController)->destroy(Auth::guard('customer')->user()->id, $model_id);
        // $carCustomerInfo = CustomerCarInfo::where('customer_id', Auth::guard('customer')->user()->id)->where('model_id', $model_id)->delete();

        // return redirect()->back();
    }
}