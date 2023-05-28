<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\AddressController;

use App\Models\User;
use App\Models\LastLocation;

use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;


class AddressCustomerController extends Controller
{
    private $baseURL = "https://dev.virtualearth.net/REST/v1";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => 'Mechanics Near You',
        ];

        return view('customer.address.mechanics_near', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $html = '';

        $results = (new AddressController)->getDistance($request->get('lat'), $request->get('long'));

        $this->saveLastLocationCustomer($request->get('lat'), $request->get('long'));

        foreach ($results as $res) {
            $user = User::find($res[0]->id);
            $user->visits;
            $html .= '<a href="'.route('customer.chat.msg', ['user' => $res[0]->id]).'">';
            $html .= '<div class="flex items-center shadow hover:bg-indigo-100 hover:shadow-lg hover:rounded transition duration-150 ease-in-out transform hover:scale-105 p-3 dark:bg-slate-200 cursor-pointer">';
            $html .= '<div class="text-l"><p class="text-gray-900 leading-none">';
            $html .= $res[0]->fname . ' [' . count($res[0]->visits) . ']</p>';
            $html .= '<p class="text-gray-600">' . $res[1] . ' ' . __('KM') . '</p>';
            $html .= '<p class="text-gray-600">' . $res[0]->phone . '</p></div></div></a>';
        }

        return $html;
    }

    public function saveLastLocationCustomer($lat, $long)
    {
        $findURL = $this->baseURL.'/Locations/'.$lat.','.$long."?key=".config('app.BingMapsKey');
        $output = file_get_contents($findURL);
        $phpArray = json_decode($output, true);
        $addressDetails = $phpArray['resourceSets'][0]['resources'][0]['address'];

        $customerLocation = LastLocation::where('customer_id', Auth::guard('customer')->user()->id)->get();

        if(count($customerLocation) == 0) {
            $lastLocation = new LastLocation();
        } else {
            $lastLocation = LastLocation::where('customer_id', Auth::guard('customer')->user()->id)->first();
        }

        $lastLocation->customer_id = Auth::guard('customer')->user()->id;
        $lastLocation->address = $addressDetails['formattedAddress'];
        $lastLocation->latitude = $lat;
        $lastLocation->longitude = $long;

        $lastLocation->save();

        return $lastLocation;
    }

}
