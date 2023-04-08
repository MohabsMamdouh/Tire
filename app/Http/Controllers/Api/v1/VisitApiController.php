<?php

namespace App\Http\Controllers\Api\v1;

// Controller
use App\Http\Controllers\Controller;

// Models
use App\Models\Visit;
use App\Models\Car;
use App\Models\Customer;
use App\Models\CarModel;
use App\Models\User;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Api\StoreVisitApiRequest;
use App\Http\Requests\Api\UpdateVisitApiRequest;

// Resources & Collection
use App\Http\Resources\v1\VisitsResource;
use App\Http\Resources\v1\VisitsCollection;

// Filters
use App\Filters\V1\VisitsFilter;

// Others
use Illuminate\Support\Facades\DB;


class VisitApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new VisitsFilter();

        $filterItmes = $filter->transform($request);

        $feedbacks = $request->query('feedbacks');

        $visits = Visit::where($filterItmes);

        if ($feedbacks) {
            $visits->with('feedbacks');
        }

        return new VisitsCollection($visits->paginate()->appends($request->query()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitApiRequest $request)
    {
        $visit = new VisitsResource(Visit::create($request->all()));

        return [
            "status" => 200,
            "data" => $visit
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Visit $visit)
    {
        $filter = new VisitsFilter();

        $filterItmes = $filter->transform($request);

        $feedbacks = $request->query('feedbacks');

        if ($feedbacks) {
            $visit->feedbacks;
        }

        return new VisitsResource($visit);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVisitApiRequest $request, Visit $visit)
    {
        $visit->update($request->all());

        return [
            "status" => 200,
            "data" => $visit,
            "msg" => "Customer updated successfully"
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
            'status' => 200,
            'msg' => 'Visit deleted successfully'
        ];
    }
}