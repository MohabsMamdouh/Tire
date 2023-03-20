<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

use App\Models\Car;
use App\Models\Customer;
use App\Models\CarModel;
use App\Models\User;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use Illuminate\Support\Facades\DB;


class VisitApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visits = DB::table('visits')
                ->join('customers', 'visits.customer_id', '=', 'customers.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'car_models.car_id', '=', 'cars.id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->select(
                    'visits.id',
                    'cars.car_name',
                    'car_models.model',
                    'visits.reason',
                    'visits.created_at',
                    'users.fname as mechanic',
                    'customers.customer_fname as customer')->get();

        return [
            'status' => 1,
            'data' => $visits
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
    public function store(Request $request)
    {
        $customer = Customer::where('customer_fname', $request['customer_fname'])->first();
        $carModel = CarModel::where('model', $request['models'])->first();

        $visit = new Visit();

        $visit->customer_id = $customer->id;
        $visit->car_model_id = $carModel->id;
        $visit->reason = $request['reason'];
        if (isset($request['stuff'])) {
            $user = User::where('fname', $request['stuff'])->first();
            $visit->user_id = $user->id;

        } else {
            $visit->user_id = Auth::user()->id;
        }
        $visit->save();

        return [
            'status' => 1,
            'data' => $visit,
            'msg' => 'Added Successfully'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function edit(Visit $visit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visit $visit)
    {

        $customer = Customer::where('customer_fname', $request['customer_fname'])->first();
        $carModel = CarModel::where('model', $request['models'])->first();

        $visit->customer_id = $customer->id;
        $visit->car_model_id = $carModel->id;
        $visit->reason = $request['reason'];

        if (isset($request['stuff'])) {
            $user = User::where('fname', $request['stuff'])->first();
            $visit->user_id = $user->id;
        } else {
            $visit->user_id = Auth::user()->id;
        }

        $visit->save();

        return [
            'status' => 1,
            'data' => $visit,
            'msg' => 'Updated-successfully'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visit $visit)
    {
        $visit->delete();

        return [
            'status' => 1,
            'msg' => 'deleted-successfully'
        ];
    }


    public function showCustomerVisits($cid)
    {
        $visits = Visit::with('model', 'user')
                    ->whereHas('customer', function ($query) use($cid){
                        $query->where('customers.id', $cid);
                    })->get();
        dd($visits);

        return [
            'status' => 1,
            'data' => $visits
        ];
    }

    public function searchVisit(Request $request)
    {
        $output = '';
        $q = $request->get('query');
        if($q != '')
        {
            $data = Visit::with('model')->whereHas('customer', function ($query) use($q){
                            $query->where('customer_fname', 'like', '%'.$q.'%');
                        }) ->orwhereHas('user', function ($query) use($q)
                        {
                            $query->where('fname', 'like', '%'.$q.'%');
                        })->get();

        } else {
            $data = Visit::with('model', 'customer', 'user')->get();
        }

        return [
            'status' => 1,
            'data' => $data
        ];

    }

    public function getCustomerVisits(Request $request)
    {
        $q = $request->get('query');

        $visits = Visit::whereHas('customer', function ($query) use($q){
                        $query->where('customer_fname', 'like', '%'.$q.'%');
                    })->get();

        return [
            'status' => 1,
            'data' => $visits
        ];
    }
}
