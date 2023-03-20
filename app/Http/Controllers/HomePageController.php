<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feeds = DB::table('feedback')
                ->join('customers', 'feedback.customer_id', '=', 'customers.id')
                ->join('visits', 'visits.id', '=', 'feedback.visit_id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'cars.id', '=', 'car_models.car_id')
                ->select(
                    'feedback.created_at',
                    'customers.customer_fname as customer',
                    'feedback.message',
                    'cars.car_name',
                    'car_models.model',
                    'users.fname as mechanic')
                ->where('feedback.status', 1)
                ->latest()->take(3)->get();


        return view('welcome', compact('feeds'));
    }
}
