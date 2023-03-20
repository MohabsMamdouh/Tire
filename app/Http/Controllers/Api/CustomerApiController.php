<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\CarController;
use App\Http\Controllers\VisitController;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\CustomerCarInfoController;


class CustomerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::with('visits')->get();
        return [
            "status" => 1,
            "data" => $customers
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $validated = $request->validated();

        $customer = new Customer();
        $customer->fill($request->all());

        $customer->save();

        return [
            "status" => 1,
            "data" => $customer
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $customer->visits;
        $customer->roles;

        $carData = (new CustomerCarInfoController)->getCustomerCarsinfo($customer->id);

        return [
            'status' => 1,
            'data' => [
                'customer' => $customer,
                'cars' => $carData
            ]
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $validated = $request->validated();

        $customer->fill($request->all());
        $customer->save();

        return [
            "status" => 1,
            "data" => $customer,
            "msg" => "Customer updated successfully"
        ];
    }


    public function showMyVisits(Customer $customer)
    {
        $visitDetails = DB::table('visits')
                        ->join('customers', 'visits.customer_id', '=', 'customers.id')
                        ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                        ->join('cars', 'car_models.car_id', '=', 'cars.id')
                        ->join('users', 'visits.user_id', '=', 'users.id')
                        ->select(
                            'customers.customer_fname as customer',
                            'cars.car_name',
                            'car_models.model',
                            'visits.reason',
                            'visits.id',
                            'visits.created_at',
                            'users.fname as mechanic',
                            )
                        ->where('customers.id', $customer->id)
                        ->get();

        return [
            'status' => 1,
            'data' => [
                'Visit Details' => $visitDetails,
            ]
        ];
    }

    public function resetPassword(UpdatePasswordRequest $request, customer $customer)
    {
        $validated = $request->validated();

        $customer->fill($request->all());
        $customer->save();

        return [
            "status" => 1,
            "data" => $customer,
            "msg" => "Password updated successfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $c = Customer::find($customer)->delete();

        return [
            "status" => 1,
            "data" => $d,
            "msg" => "Blog deleted successfully"
        ];
    }
}