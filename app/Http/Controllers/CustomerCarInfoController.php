<?php

namespace App\Http\Controllers;

use App\Models\CustomerCarInfo;

use App\Models\Customer;
use App\Models\Car;
use App\Models\CarModel;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CustomerCarInfoController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCustomerCar($customer_id)
    {
        $customer = Customer::find($customer_id);

        $cars = Car::with('models')->orderBy('car_name')->get();

        $data = [
            'customer' => $customer,
            'cars' => $cars,
            'title' => 'Add car for customer'
        ];

        return view('cars.carCustomer', $data);
    }

    public function storeCustomerCar(Request $request)
    {
        $model = CarModel::where('model', $request['models'])->first();

        $customer = Customer::where('customer_fname', $request['fname'])->first();

        $customer->models()->attach($model->id);

        return redirect()->route('customer.ShowSingle', ['id' => $customer->id]);
    }

    public function getCustomerCarsinfo($cid)
    {
        $data = CarModel::with('car')->whereHas('customers', function ($query) use($cid){
                            $query->where('customers.id', $cid);
                        })->get();

        return $data;
    }


    public function getCustomerCar(Request $request)
    {
        $output = '';
        $q = $request->get('query');
        if($q != '')
        {
            $data = CarModel::with('car')->whereHas('customers', function ($query) use($q){
                                $query->where('customer_fname', 'like', '%'.$q.'%');
                            })->get();

            return $data;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($cid, $model_id)
    {
        $carCustomerInfo = CustomerCarInfo::where('customer_id', $cid)->where('model_id', $model_id)->delete();

        return redirect()->back();
    }
}