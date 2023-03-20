<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countVisits = count(Visit::all());
        $visits = Visit::with('customer', 'model', 'user')->latest()->take(5)->get();
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
        $countCustomers = count(Customer::all());
        $countStuff = count(User::all());
        $cars = Car::with('models')->get();

        return [
            'status' => 1,
            'data' => [
                'countVisits' => $countVisits,
                'visits' => $visits,
                'countFeeds' => $countFeeds,
                'feeds' => $feeds,
                'countCustomers' => $countCustomers,
                'countStuff' => $countStuff,
                'cars' => $cars,
            ]
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $user = new User();
        $user->fill($request->all());
        $user->save();

        $user->assignRole($request['roles']);

        return [
            'status' => 1,
            'data' => $user
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->roles;
        $user->visits;

        return [
            'status' => 1,
            'user' => $user,
        ];

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

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

        return [
            'status' => 1,
            'msg' => 'updated-successfully'
        ];
    }

    public function resetPassword(UpdatePasswordRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->fill($request->all());
        $user->save();

        return [
            'status' => 1,
            'msg' => 'Password-updated-successfully'
        ];
    }

    public function showAll()
    {
        $users = User::with('visits')->get();

        return [
            'status' => 1,
            'data' => $users,
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(!$user->hasRole('super_admin')) {
            $user->delete();
            return [
                'status' => 1,
                'msg' => 'deleted-successfully'
            ];
        }

        return [
            'status' => 0,
            'msg' => "You can't Delete This user"
        ];
    }
}
