<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerCarInfo;
use App\Models\Visit;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $cus_id = Auth::guard('customer')->user()->id;

        $countCars = CustomerCarInfo::where('customer_id', $cus_id)->count();
        $countVisits = Visit::where('customer_id', $cus_id)->count();
        $countMechanic = User::whereHas('visits', function ($query) use($cus_id){
                                $query->where('customer_id', $cus_id);
                            })->count();
        $countFeeds = Feedback::where('customer_id', $cus_id)->count();

        $Visits = DB::table('visits')
                ->join('customers', 'visits.customer_id', '=', 'customers.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'car_models.car_id', '=', 'cars.id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->select('cars.car_name', 'car_models.model', 'visits.reason', 'users.fname as mechanic')
                ->where('customers.id', $cus_id)
                ->take(5)->get();
        $feeds = DB::table('feedback')
                ->join('customers', 'feedback.customer_id', '=', 'customers.id')
                ->join('visits', 'visits.id', '=', 'feedback.visit_id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'cars.id', '=', 'car_models.car_id')
                ->where('customers.id', $cus_id)
                ->select('feedback.created_at', 'customers.customer_fname','feedback.message','cars.car_name', 'car_models.model','users.fname')
                ->latest()->take(3)->get();

        return view('customer.dashboard', [
            'countCars' => $countCars,
            'countVisits' => $countVisits,
            'countMechanic' => $countMechanic,
            'countFeeds' => $countFeeds,
            'Visits' => $Visits,
            'feeds' => $feeds,
            'title' => 'Dashboard',
        ]);
    }
}