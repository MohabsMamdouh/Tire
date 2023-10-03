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
use Illuminate\Http\Request;


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
        // $customer->location;
        // $result = '<div class="flex flex-col dark:text-gray-200">
        //                 <div class="font-semibold text-xl py-4">';
        // $result .= $customer->customer_fname;
        // $result .= '</div>';

        // $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.__('Joined since: ').'</b>'.str_replace('-', ' ', date('F j, Y', strtotime($customer->created_at))).'</div>';
        // $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$customer->phone.'</div>';
        // $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.wordwrap($customer->email, 15, "<br>", true).'</div>';
        // $result .= '<div class="font-semibold py-4 dark:text-gray-200">'.$customer->customer_address.'</div>';
        // $result .= '</div>';


        // return $result;

        return $customer;
    }

    public function searchChat(Request $request)
    {
        $output = '';
        $q = $request->get('query');

        if($q != '')
        {
            $data = Customer::where('customer_fname', 'like', '%'.$q.'%')->get();
        } else {
            $data = Customer::all();
        }

        $head = '<div class="userList-item-';
        $c_head = ' flex flex-row py-4 px-2 justify-center cursor-pointer hover:bg-gray- items-center border-b-2 dark:border-gray-400">
                    <div class="w-50 dark:text-white border border-gray-300 rounded-full mx-auto bg-gray-700 text-center p-2">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="w-full ml-2">';

        $cid = '<input type="hidden" class="cid" name="cid" value="';

        $cName = '"><div id="Cname" class="text-lg font-semibold dark:text-gray-300">';

        $tail = '</div></div></div>';

        if (count($data) > 0) {
            foreach ($data as $customer) {
                $output .= $head . $customer->id . $c_head . $cid . $customer->id . $cName . $customer->customer_fname . $tail;
                $output .= "
                    <script>
                        $(document).ready(function () {

                            $('.userList-item-".$customer->id."').on('click', function() {
                                getMessages('".$customer->id."');
                                customerInfo('".$customer->id."');
                                $('.controller').removeClass('hidden');
                            });
                        });
                    </script>";
            }
        } else {
            $output .= $head . $c_head . $cid . $cName . "Not Found" . $tail;
        }

        return $output;
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
