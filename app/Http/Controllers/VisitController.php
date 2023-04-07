<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Car;
use App\Models\Customer;
use App\Models\CarModel;
use App\Models\User;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('show all visits')){
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

        } else {
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
                    'customers.customer_fname as customer')
                    ->where('users.id', Auth::user()->id)->get();
        }

        $data = [
            'visits' => $visits,
            'title' => 'Visits'
        ];

        return view('visits.show', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        $users = User::all();

        $data = [
            'customers' => $customers,
            'users' => $users,
            'title' => 'Create Visit'
        ];

        return view('visits.visit-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVisitRequest  $request
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

        return redirect()->route('visit.showAll');
    }


    public function getCustomerVisits(Request $request)
    {
        $q = $request->get('query');

        $visits = Visit::whereHas('customer', function ($query) use($q){
                        $query->where('customer_fname', 'like', '%'.$q.'%');
                    })->get();

        // $feeds = DB::table('visits')
        //             ->join('customers', 'feedback.customer_id', '=', 'customers.id')
        //             ->join('visits', 'visits.id', '=', 'feedback.visit_id')
        //             ->join('users', 'visits.user_id', '=', 'users.id')
        //             ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
        //             ->join('cars', 'cars.id', '=', 'car_models.car_id')
        //             ->select('feedback.id', 'feedback.created_at', 'customers.customer_fname','feedback.message','cars.car_name', 'car_models.model','users.fname')
        //             ->where('status', 0)
        //             ->get();

        return $visits;
    }


    public function searchVisit(Request $request)
    {
        $cars = Car::with('models')->get();
        $output = '';
        $q = $request->get('query');
        if($q != '')
        {
            if(Auth::user()->can('show all visits')) {
                $data = Visit::with('model')->whereHas('customer', function ($query) use($q){
                                $query->where('customer_fname', 'like', '%'.$q.'%');
                            }) ->orwhereHas('user', function ($query) use($q)
                            {
                                $query->where('fname', 'like', '%'.$q.'%');
                            })->get();
            } else {
                $data = Visit::with('model')
                            ->where('user_id', Auth::user()->id)
                            ->whereHas('customer', function ($query) use($q){
                                $query->where('customer_fname', 'like', '%'.$q.'%');
                            })->orwhereHas('user', function ($query) use($q)
                            {
                                $query->where('fname', 'like', '%'.$q.'%');
                            })->get();
            }

        } else {
            if(Auth::user()->can('show all visits')) {
                $data = Visit::with('model', 'customer', 'user')->get();
            } else {
                $data = Visit::with('model', 'customer', 'user')->where('user_id', Auth::user()->id)->get();
            }
        }

        $total_row = count($data);
        if($total_row > 0)
        {
            $output .= '<tr>';

            foreach($data as $visit)
            {
                    $output .= '<tr>';
                    $output .= '<td class="border px-2 py-2">'.$visit->customer->customer_fname.'</td>';

                    foreach ($cars as $car) {
                        foreach ($car->models as $model ) {
                            if ($model->model == $visit->model->model) {
                                $output .= '<td class="border px-2 py-2">'.$car->car_name.'</td>';
                                break;
                            }
                        }
                    }

                    $output .='
                        <td class="border px-2 py-2">'.$visit->model->model.'</td>
                        <td class="border px-2 py-2">'.$visit->reason.'</td>
                        <td class="border px-2 py-2">'.$visit->user->fname.'</td>
                        <td class="border px-2 py-2"><a href="'.route('visit.edit', ['id' => $visit->id]).'"
                        class="text-blue-400 underline">'. _('Edit').'</a></td>
                    ';
                    $output .= '</tr>';
            }
        } else {
            $output = '
            <tr>
                <td align="center" colspan="5">No Data Found</td>
            </tr>
            ';
        }
        $data = array(
            'table_data'  => $output,
        );

        foreach ($data as $d) {
            echo $d;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('show all visits')) {
            $visit = Visit::with('model', 'customer', 'user')->find($id);
        } else {
            $visit = Visit::with('model', 'customer', 'user')->where('user_id', Auth::user()->id)->find($id);

            if($visit == null) {
                return abort(404);
            }
        }

        $customers = Customer::all();
        $users = User::all();
        $cars = Car::with('models')->get();
        $customer = Customer::with('models')->find($visit->customer->id);

        $data = [
            'visit' => $visit,
            'customers' => $customers,
            'customer' => $customer,
            'users' => $users,
            'cars' => $cars,
            'title' => 'Edit Visit'
        ];

        return view('visits.visit-form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVisitRequest  $request
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('show all visits')) {
            $visit = Visit::with('model', 'customer', 'user')->find($id);
        } else {
            $visit = Visit::with('model', 'customer', 'user')->where('user_id', Auth::user()->id)->find($id);

            if($visit == null) {
                return abort(404);
            }
        }

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

        return redirect()->route('visit.showAll');
    }

    public function showCustomerVisits($cid)
    {

        if(Auth::user()->can('show all visits')) {
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
                            'customers.customer_fname as customer')
                            ->where('customers.id', $cid)->get();
        } else {
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
                            'customers.customer_fname as customer')
                        ->where('customers.id', $cid)
                        ->where('users.id', Auth::user()->id)
                        ->get();
        }

        return $visits;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('show all visits')) {
            $visit = Visit::find($id);
        } else {
            $visit = Visit::where('user_id', Auth::user()->id)->find($id);

            if($visit == null) {
                return abort(404);
            }
        }

        $visit->delete();

        return redirect()->route('visit.showAll');
    }
}