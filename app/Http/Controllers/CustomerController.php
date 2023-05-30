<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use App\Models\Car;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\CustomerCarInfoController;
use App\Http\Controllers\VisitController;



class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function showAll()
    {
        $customers = Customer::with('visits')->get();

        $data = [
            'customers' => $customers,
            'title' => 'Customers'
        ];

        return view('customers.show', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('name', '=', 'customer') ->orWhere('name', '=', 'guest')->get();

        $data = [
            'roles' => $roles,
            'title' => 'Create Customer'
        ];

        return view('customers.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $validated = $request->validated();

        $customer = new Customer();
        $customer->fill($request->all());

        $customer->save();

        $customer->assignRole($request['roles']);

        // $customer->assignRole($request['roles']);

        return redirect()->route('customer.ShowSingle', ['id' => $customer->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::with('visits', 'feedbacks')->find($id);

        $carData = (new CustomerCarInfoController)->getCustomerCarsinfo($id);

        $data = [
            'customer' => $customer,
            'carData' => $carData,
            'title' => 'Show Customer'
        ];

        return view('customers.ShowSingle', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $customer = Customer::find($id);

        $roles = Role::where('name', '=', 'customer') ->orWhere('name', '=', 'guest')->get();

        $data = [
            'customer' => $customer,
            'roles' => $roles,
            'title' => 'Edit Customer'
        ];

        return view('customers.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $validated = $request->validated();

        $customer = Customer::find($id);

        $customer->fill($request->all());
        $customer->save();

        if (!$customer->hasRole($request['roles'])) {
            if (isset($customer->roles[0])) {
                foreach ($customer->roles as $role) {
                    $customer->removeRole($role->name);
                }
            }
            $customer->assignRole($request['roles']);
        }

        return redirect(route('customer.ShowSingle', ['id' => $id]));
    }

    public function showMyVisits($id)
    {
        $visits = (new VisitController)->showCustomerVisits($id);
        $cars = Car::with('models')->get();

        $data = [
            'visits' => $visits,
            'cars' => $cars,
            'title' => 'Show Customer Visits'
        ];

        return view('customers.visits', $data);

    }

    public function resetPassword(UpdatePasswordRequest $request, $id)
    {
        $validated = $request->validated();

        $customer = Customer::find($id);

        // $customer->password = Hash::make($request['password']);
        $customer->fill($request->all());
        $customer->save();

        return redirect(route('customer.ShowSingle', ['id' => $id]));
    }

    public function getCustomerInfo(Customer $customer)
    {
        $customer->location;
        $result = '<div class="flex flex-col dark:text-gray-200">
                        <div class="font-semibold text-xl py-4">';
        $result .= $customer->customer_fname;
        $result .= '</div>';
        $result .= '<div id="map">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3876.940537254977!2d-122.43129768566308!3d37.77397297762194!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085806c7d9e7d09%3A0x4a501367f076ad3a!2sGolden%20Gate%20Bridge!5e0!3m2!1sen!2sus!4v1622115157889!5m2!1sen!2sus&center='.$customer->location->latitude.','.$customer->location->longitude.'&zoom=12&maptype=satellite"
                width="200" height="150"
                style="border:0;" loading="lazy">
            </iframe>
            <div>'.$customer->location->address.' <a href="https://www.google.com/maps/search/?api=1&query='.$customer->location->latitude.','.$customer->location->longitude.'"><i class="fa-solid fa-map"></i></a></div>
        </div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$customer->created_at.'</div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$customer->phone.'</div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$customer->email.'</div>';
        $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$customer->customer_address.'</div>';
        $result .= '</div>';


        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::where('id', $id)->delete();

        return redirect(route('customer.showAll'));
    }


}
