<?php

namespace App\Http\Controllers\Api\v1;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\Customer;
use App\Models\CarModel;
use App\Models\Visit;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Api\StoreCustomerApiRequest;
use App\Http\Requests\Api\UpdateCustomerApiRequest;
use App\Http\Requests\Api\UpdatePasswordApiRequest;

// Resources & Collection
use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\v1\CustomerCollection;
use App\Http\Resources\v1\VisitsResource;
use App\Http\Resources\v1\VisitsCollection;

// Filters
use App\Filters\V1\CustomersFilter;
use App\Filters\V1\VisitsFilter;


class CustomerApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new CustomersFilter();

        $filterItmes = $filter->transform($request);

        $carModels = $request->query('carModels');

        $visits = $request->query('visits');

        $feedbacks = $request->query('feedbacks');

        $customers = Customer::where($filterItmes);

        if ($carModels) {
            $customers->with('models');
        }

        if ($visits) {
            $customers->with('visits');
        }

        if ($feedbacks) {
            $customers->with('feedbacks');
        }

        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerApiRequest $request)
    {
        $customer = new CustomerResource(Customer::create($request->all()));

        $customer->assignRole($request['roles']);

        return [
            "status" => 200,
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
        $carModels = request()->query('carModels');

        $visits = request()->query('visits');

        $feedbacks = request()->query('feedbacks');

        $roles = request()->query('roles');

        if ($carModels) {
            $customer->models;
        }

        if ($visits) {
            $customer->visits;
        }

        if ($feedbacks) {
            $customer->feedbacks;
        }

        if ($roles) {
            $customer->roles;
        }

        return new CustomerResource($customer);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerApiRequest $request, Customer $customer)
    {
        $customer->update($request->all());

        return [
            "status" => 200,
            "data" => $customer,
            "msg" => "Customer updated successfully"
        ];
    }


    public function showMyVisits(Customer $customer)
    {

        $filter = new VisitsFilter();

        $request = new Request(['customerId' => ["eq" => $customer->id]]);

        $filterItmes = $filter->transform($request);

        $visits = Visit::where($filterItmes);

        $visits->with('customer');
        $visits->with('model');
        $visits->with('user');
        $visits->with('feedbacks');

        return new VisitsCollection($visits->paginate());
    }

    public function resetPassword(UpdatePasswordApiRequest $request, customer $customer)
    {
        $customer->update($request->all());

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
        $customer->delete();

        return [
            "status" => 1,
            "data" => $customer,
            "msg" => "Customer deleted successfully"
        ];
    }
}