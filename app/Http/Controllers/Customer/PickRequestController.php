<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use App\Models\PickRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreRequestRequest;
use App\Http\Requests\UpdateRequestRequest;

class PickRequestController extends Controller
{

    public function index(User $user)
    {
        $user->addresses;
        // $user->feedbacks;

        $feeds = DB::table('feedback')
                ->join('customers', 'feedback.customer_id', '=', 'customers.id')
                ->join('visits', 'visits.id', '=', 'feedback.visit_id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'cars.id', '=', 'car_models.car_id')
                ->select('feedback.id', 'feedback.created_at', 'customers.customer_fname as customer','feedback.message','cars.car_name', 'car_models.model','users.fname')
                ->where('users.id', $user->id)
                ->where('status', 1)
                ->get();
        $data = [
            'user' => $user,
            'title' => "Request",
            'feeds' => $feeds
        ];

        return view('customer.picks.pick', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRequestRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, Customer $customer)
    {
        // return "hhhh";
        $PickRequest = new PickRequest();
        $PickRequest->status = "pending";
        $PickRequest->customer_id = $customer->id;
        $PickRequest->user_id = $user->id;
        $PickRequest->save();

        return "Pending";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRequestRequest  $request
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PickRequest $PickRequest)
    {
        if ($request->get('status') == 0) {
            $PickRequest->status = "On His Way";
        } else {
            $PickRequest->status = "Can't Make it";
        }

        return true;
    }

    public function checkStatus(User $user, Customer $customer)
    {
        $lastHour = now()->subHour(); // get the timestamp for one hour ago

        $PickRequest = PickRequest::whereBetween('created_at', [$lastHour, now()])
                                ->where('user_id', $user->id)
                                ->where('customer_id', $customer->id)->latest()->first();
        if ($PickRequest != null) {
            return $PickRequest->status;
        } else {
            return " ";
        }
    }
}
