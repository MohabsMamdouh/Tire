<?php

namespace App\Http\Controllers\Api\v1;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\Feedback;
use App\Models\Customer;
use App\Models\Visit;

// Resources & Collection
use App\Http\Resources\v1\FeedbacksResource;
use App\Http\Resources\v1\FeedbacksCollection;
use App\Http\Resources\v1\VisitsResource;
use App\Http\Resources\v1\VisitsCollection;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Api\StoreFeedbackApiRequest;
use App\Http\Requests\Api\UpdateFeedbackApiRequest;

// Filters
use App\Filters\V1\FeedbacksFilter;

// Illuminate
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FeedbackApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new FeedbacksFilter();

        $filterItmes = $filter->transform($request);

        $feedbacks = Feedback::where($filterItmes);

        $visit = $request->query('visit');

        if ($visit) {
            $feedbacks->with('visit');
        }

        return new FeedbacksCollection($feedbacks->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFeedbackRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeedbackApiRequest $request)
    {
        $feedback = Feedback::create($request->all());

        return [
            'status' => 200,
            'data' => $feedback,
            'msg' => 'Added Successfully'
        ];
    }

    public function show(Feedback $feedback)
    {
        # code...
    }

    public function update(Feedback $feedback)
    {
        $feedback->status = 1;
        $feedback->save();

        return [
            'status' => 200,
            'data' => $feedback,
            'msg' => 'Feedback Accepted'
        ];
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

        return [
            'status' => 200,
            'msg' => 'Deleted Successfully'
        ];
    }
}