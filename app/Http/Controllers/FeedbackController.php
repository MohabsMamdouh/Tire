<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Customer;
use App\Http\Requests\StoreFeedbackRequest;
use App\Http\Requests\UpdateFeedbackRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if(Auth::user()->can('show all feeds')){

            $feeds = DB::table('feedback')
                ->join('customers', 'feedback.customer_id', '=', 'customers.id')
                ->join('visits', 'visits.id', '=', 'feedback.visit_id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'cars.id', '=', 'car_models.car_id')
                ->select('feedback.id', 'feedback.created_at', 'customers.customer_fname','feedback.message','cars.car_name', 'car_models.model','users.fname')
                ->where('status', 1)
                ->get();
        } else {
            $feeds = DB::table('feedback')
                ->join('customers', 'feedback.customer_id', '=', 'customers.id')
                ->join('visits', 'visits.id', '=', 'feedback.visit_id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'cars.id', '=', 'car_models.car_id')
                ->select('feedback.id', 'feedback.created_at', 'customers.customer_fname','feedback.message','cars.car_name', 'car_models.model','users.fname')
                ->where('users.id', Auth::user()->id)
                ->where('status', 1)
                ->get();
        }

        $data = [
            'feeds' => $feeds,
            'title' => 'Feedbacks'
        ];

        return view('feedbacks.show', $data);
    }

    public function acceptFeed()
    {
        $feeds = DB::table('feedback')
                ->join('customers', 'feedback.customer_id', '=', 'customers.id')
                ->join('visits', 'visits.id', '=', 'feedback.visit_id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'cars.id', '=', 'car_models.car_id')
                ->select('feedback.id', 'feedback.created_at', 'customers.customer_fname','feedback.message','cars.car_name', 'car_models.model','users.fname')
                ->where('status', 0)
                ->get();

        $data = [
            'feeds' => $feeds,
            'title' => 'None Accepted Feedbacks'
        ];

        return view('feedbacks.show', $data);
    }

    public function accept(Feedback $feedback)
    {
        $feedback->status = 1;
        $feedback->save();

        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();

        $data = [
            'customers' => $customers,
            'title' => 'Create Feedback'
        ];

        return view('feedbacks.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFeedbackRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeedbackRequest $request)
    {
        $validated = $request->validated();
        $customer = Customer::where('customer_fname', $request['customer_fname'])->first();

        $feed = new Feedback();

        $feed->customer_id = $customer->id;
        $feed->message = $request['message'];
        $feed->visit_id = $request['visits'];

        $feed->save();

        return redirect(route('feed.show_accept'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('feed.showAll');
    }
}
