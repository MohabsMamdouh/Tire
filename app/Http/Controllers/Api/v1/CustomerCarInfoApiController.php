<?php

namespace App\Http\Controllers\Api\v1;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\CarModel;
use App\Models\Customer;

// Requests
use Illuminate\Http\Request;

// Resources & Collection
use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\v1\CustomerCollection;

class CustomerCarInfoApiController extends Controller
{
    public function storeCustomerCar(Request $request)
    {

        $model = CarModel::find($request['model']);

        $customer = Customer::find($request['customer']);

        $customer->models()->attach($model->id);

        return [
            'status' => 200,
            'msg' => 'Car Addedd Successfully'
        ];
    }

    public function getCustomerCarsinfo(Customer $customer)
    {
        $customer->models;

        return new CustomerResource($customer);
    }

    public function destroy(Request $request)
    {
        // $carCustomerInfo = CustomerCarInfo::where('customer_id', $cid)->where('model_id', $model_id)->delete();
        $customer = Customer::find($request['customer']);

        $customer->models()->wherePivot('model_id', '=', $request['model'])->detach();

        return [
            'status' => 200,
            'msg' => 'Deleted Successfully'
        ];
    }
}