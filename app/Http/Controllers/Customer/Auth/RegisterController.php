<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\Auth\RegisterCustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Str;



class RegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('customer.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterCustomerRequest $request)
    {
        $validated = $request->validated();

        // dd($request->all());

        $customer = new Customer();
        $customer->fill($request->all());
        $customer->customer_username = Str::lower(str_replace(' ', '', $request->customer_fname));
        // dd(Str::lower(str_replace(' ', '', $request->customer_fname)));
        $customer->save();
        $customer->assignRole('customer');

        event(new Registered($customer));

        Auth::guard('customer')->login($customer);

        return redirect(RouteServiceProvider::CUSTOMER_HOME);
    }
}