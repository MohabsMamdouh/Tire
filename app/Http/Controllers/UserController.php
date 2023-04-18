<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
use App\Models\Visit;
use App\Models\Car;
use App\Models\Feedback;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('show all visits')) {
            $countVisits = count(Visit::all());
            $countFeeds = count(Feedback::all());

            $feeds = DB::table('feedback')
                ->join('customers', 'feedback.customer_id', '=', 'customers.id')
                ->join('visits', 'visits.id', '=', 'feedback.visit_id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'cars.id', '=', 'car_models.car_id')
                ->select('feedback.created_at', 'customers.customer_fname','feedback.message','cars.car_name', 'car_models.model','users.fname')
                ->where('feedback.status', 1)
                ->latest()->take(3)->get();

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
                        'users.fname as mechanic',
                        'customers.customer_fname as customer')->take(3)->get();

        } else {
            $countVisits = count(Visit::where('user_id', Auth::user()->id)->get());
            $countFeeds = count(Feedback::all());
            $feeds = DB::table('feedback')
                ->join('customers', 'feedback.customer_id', '=', 'customers.id')
                ->join('visits', 'visits.id', '=', 'feedback.visit_id')
                ->join('users', 'visits.user_id', '=', 'users.id')
                ->join('car_models', 'visits.car_model_id', '=', 'car_models.id')
                ->join('cars', 'cars.id', '=', 'car_models.car_id')
                ->select('feedback.created_at', 'customers.customer_fname','feedback.message','cars.car_name', 'car_models.model','users.fname')
                ->where('users.id', Auth::user()->id)
                ->where('feedback.status', 1)
                ->latest()->take(3)->get();

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
                    'users.fname as mechanic',
                    'customers.customer_fname as customer')
                    ->where('user_id', Auth::user()->id)->take(5)->get();
        }
        $countCustomers = count(Customer::all());
        $countStuff = count(User::all());

        $data = [
            'countCustomers' => $countCustomers,
            'countStuff' => $countStuff,
            'countVisits' => $countVisits,
            'visits' => $visits,
            'countFeeds' => $countFeeds,
            'feeds' => $feeds,
            'title' => 'Dashboard',
        ];

        return view('dashboard', $data);
    }

    public function showAll()
    {
        $users = User::with('visits')->get();

        $data = [
            'users' => $users,
            'title' => 'Mechanics'
        ];

        return view('users.show', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name', '<>', 'super_admin')->where('name', '<>', 'customer')->get();

        $data = [
            'roles' => $roles,
            'title' => 'Create Mechanic'
        ];

        return view('users.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = new User();
        $user->fill($request->all());
        $user->save();

        $user->assignRole($request['roles']);

        return redirect()->route('user.ShowSingle', ['id' => $user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('visits', 'roles')->find($id);

        $customers = Customer::with('models')->get();

        $cars = Car::with('models')->get();

        $data = [
            'user' => $user,
            'customers' => $customers,
            'cars' => $cars,
            'title' => 'Show Mechanic'
        ];

        return view('users.ShowSingle', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('roles')->find($id);

        $roles = Role::where('name', '<>', 'super_admin')->where('name', '<>', 'customer')->get();

        $data = [
            'user' => $user,
            'roles' => $roles,
            'title' => 'Edit Mechanic'
        ];

        return view('users.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();

        $user = User::with('roles')->find($id);

        $user->fill($request->all());
        $user->save();

        if (!$user->hasRole($request['roles'])) {
            if (isset($user->roles[0])) {
                foreach ($user->roles as $role) {
                    $user->removeRole($role->name);
                }
            }
            $user->assignRole($request['roles']);
        }

        return redirect(route('user.ShowSingle', ['id' => $id]));
    }


    public function resetPassword(UpdatePasswordRequest $request, $id)
    {
        $validated = $request->validated();

        $user = User::find($id);

        $user->fill($request->all());
        $user->save();

        return redirect(route('user.ShowSingle', ['id' => $id]));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->first();

        if(!$user->hasRole('super_admin')) {
            $user->delete();
            return redirect(route('user.showAll'));
        }

        return redirect()->back()->withErrors(['super_admin' => "You can't Delete This user"]);
    }
}
