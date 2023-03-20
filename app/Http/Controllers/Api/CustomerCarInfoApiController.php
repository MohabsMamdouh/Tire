<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerCarInfoApiController extends Controller
{
    public function storeCustomerCar(Request $request)
    {

        $model = CarModel::where('model', $request['models'])->first();

        $customer = Customer::where('customer_fname', $request['fname'])->first();

        $customerCarInfo = new CustomerCarInfo();

        $customerCarInfo->model_id = $model->id;
        $customerCarInfo->customer_id = $customer->id;

        $customerCarInfo->save();

        return [
            'status' => 1,
            'msg' => 'Addedd Successfully'
        ];
    }

    public function getCustomerCarsinfo($cid)
    {
        $data = CarModel::with('car')->whereHas('customers', function ($query) use($cid){
                            $query->where('customers.id', $cid);
                        })->get();

        return [
            'status' => 1,
            'data' => $data
        ];
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

            return [
                'status' => 1,
                'data' => $data
            ];
        }
    }

    public function destroy($cid, $model_id)
    {
        $carCustomerInfo = CustomerCarInfo::where('customer_id', $cid)->where('model_id', $model_id)->delete();

        return [
            'status' => 1,
            'msg' => 'Deleted Successfully'
        ];
    }
}
