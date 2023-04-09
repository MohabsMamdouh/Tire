<?php

namespace App\Http\Controllers\Api\v1;

// Controllers
use App\Http\Controllers\Controller;

// Models
use App\Models\User;
use App\Models\Customer;
use App\Models\Visit;
use App\Models\Feedback;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\Api\UpdateUserApiRequest;
use App\Http\Requests\Api\UpdatePasswordApiRequest;
use App\Http\Requests\Api\StoreUserApiRequest;

// Resources & Collection
use App\Http\Resources\v1\FeedbacksResource;
use App\Http\Resources\v1\FeedbacksCollection;
use App\Http\Resources\v1\VisitsResource;
use App\Http\Resources\v1\VisitsCollection;
use App\Http\Resources\v1\UsersResource;
use App\Http\Resources\v1\UsersCollection;

// Filters
use App\Filters\V1\UsersFilter;

// Others
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
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
        // Counts Item
        $countCustomers = count(Customer::all());
        $countStuff = count(User::all());
        $countVisits = count(Visit::all());
        $countFeeds = count(Feedback::all());

        // Data
        $visits = new VisitsCollection(Visit::latest()->take(3)->get());
        $feedbacks = new FeedbacksCollection(Feedback::with('visit')->latest()->take(3)->get());

        return [
            'status' => 200,
            'data' => [
                'countCustomers' => $countCustomers,
                'countStuff' => $countStuff,
                'countVisits' => $countVisits,
                'countFeeds' => $countFeeds,
                'visits' => $visits,
                'feedbacks' => $feedbacks,
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreUserApiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserApiRequest $request)
    {
        $user = new UsersResource(User::create($request->all()));

        $user->assignRole($request['roles']);

        return [
            "status" => 200,
            "data" => $user
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
        $visits = request()->query('visits');

        $roles = request()->query('roles');

        $address = request()->query('address');

        if ($visits) {
            $user->visits;
        }

        if ($roles) {
            $user->roles;
        }

        if ($address) {
            $user->addresses;
        }

        return new UsersResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserApiRequest $request, User $user)
    {
        $user->update($request->all());

        if (!$user->hasRole($request['roles'])) {
            if (isset($user->roles[0])) {
                foreach ($user->roles as $role) {
                    $user->removeRole($role->name);
                }
            }
            $user->assignRole($request['roles']);
        }

        return [
            'status' => 200,
            'usr' => $user,
            'msg' => 'updated-successfully'
        ];
    }

    public function resetPassword(UpdatePasswordApiRequest $request, User $user)
    {
        $user->update($request->all());

        return [
            'status' => 200,
            'msg' => 'Password-updated-successfully'
        ];
    }

    public function showAll(Request $request)
    {
        $filter = new UsersFilter();

        $filterItmes = $filter->transform($request);

        $visits = $request->query('visits');

        $address = request()->query('address');

        $users = User::where($filterItmes);

        if ($address) {
            $users->with('addresses');
        }

        if ($visits) {
            $users->with('visits');
        }

        return new UsersCollection($users->paginate()->appends($request->query()));
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
