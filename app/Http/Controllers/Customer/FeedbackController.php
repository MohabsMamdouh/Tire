<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function index()
    {
        $feeds = DB::table('feedback')
                ->join('customers', 'feedback.customer_id', '=', 'customers.id')
                ->join('visits', 'visits.id', '=', 'feedback.visit_id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'cars.id', '=', 'car_models.car_id')
                ->select('feedback.id', 'feedback.created_at', 'customers.customer_fname','feedback.message','cars.car_name', 'car_models.model','users.fname')
                ->where('customers.id', Auth::guard('customer')->user()->id)
                ->get();

        $data = [
            'feeds' => $feeds,
            'title' => 'My Feedbacks'
        ];

        return view('customer.feedbacks.show', $data);
    }

    public function create($visit)
    {
        $data = [
            'visit' => $visit,
            'title' => 'create feedback'
        ];

        return view('customer.feedbacks.form', $data);
    }

    public function store(Request $request, $visit)
    {
        $request->validate([
            'message' => 'required',
        ]);

        $feed = new Feedback();
        $feed->customer_id = Auth::guard('customer')->user()->id;
        $feed->visit_id = $visit;
        $feed->message = $request->message;

        $feed->save();

        return redirect()->route('customer.feeds.MyFeeds');
    }

    public function destroy(Feedback $feedback)
    {
        if ($feedback->customer_id != Auth::guard('customer')->user()->id) {
            return redirect(route('customer.dashboard'));
        }

        $feedback->delete();

        return redirect(route('customer.dashboard'));
    }
}
