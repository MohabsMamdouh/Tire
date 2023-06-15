<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class VisitController extends Controller
{
    public function index()
    {
        $visits = DB::table('visits')
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
                    'users.fname as mechanic')
                ->where('customers.id', Auth::guard('customer')->user()->id)->get();

        $data = [
            'visits' => $visits,
            'title' => 'Give a Feedback',
        ];

        return view('customer.visits.show', $data);
    }
}
