<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;


class AddressController extends Controller
{
    private $BingMapsKey = 'Ag0mGd-pnqRtYoueECNNzDNwARA_yN-agnPrcMzrVPsG3piMytyERDlXfkRhnmwQ';

    private $baseURL = "https://dev.virtualearth.net/REST/v1";

    // private $distanceURL = "https://dev.virtualearth.net/REST/v1";

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Add Your Location',
        ];

        return view('address.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        * Compose URI for Locations API request
        *
        * http://dev.virtualearth.net/REST/v1/Locations/countryRegion/adminDistrict/postalCode/locality/addressLine?key=yourBingMapsKey => with Address
        *
        * http://dev.virtualearth.net/REST/v1/Locations/{point}?key={BingMapsKey} => with latitude & longtitude
        *
        */

        $findURL = $this->baseURL.'/Locations/'.$request['latitude'].','.$request['longitude']."?key=".$this->BingMapsKey;

        // get the response from the Locations API and store it in a string
        $output = file_get_contents($findURL);

        // $xmlObject = simplexml_load_string($output);

        // $json = json_encode($xmlObject);
        $phpArray = json_decode($output, true);

        $addressDetails = $phpArray['resourceSets'][0]['resources'][0]['address'];

        $userAdd = Address::where('user_id', Auth::user()->id)->get();

        if(count($userAdd) == 0) {
            $address = new Address();
        } else {
            $address = Address::where('user_id', Auth::user()->id)->get()->first();
        }

            $address->user_id = Auth::user()->id;
            $address->address_address = $addressDetails['formattedAddress'];
            $address->address_latitude = $request['latitude'];
            $address->address_longitude = $request['longitude'];
            $address->address_ZipCode = '17444';
            // dd($addressDetails);
            $address->save();

        return redirect()->back()->with('status', 'Added Successfully');
    }

    public function mechanicsNearME()
    {
        $data = [
            'title' => 'Mechanics Near You',
        ];

        return view('address.mechanics_near', $data);
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

        $results = $this->getDistance($request->get('lat'), $request->get('long'));

        foreach ($results as $res) {
            $user = User::find($res[0]->id);
            $user->visits;
            $html .= '<a href="#">';
            $html .= '<div class="flex items-center shadow hover:bg-indigo-100 hover:shadow-lg hover:rounded transition duration-150 ease-in-out transform hover:scale-105 p-3 dark:bg-slate-200 cursor-pointer">';
            $html .= '<div class="text-l"><p class="text-gray-900 leading-none">';
            $html .= $res[0]->fname . ' [' . count($res[0]->visits) . ']</p>';
            $html .= '<p class="text-gray-600">' . $res[1] . ' ' . __('KM') . '</p>';
            $html .= '<p class="text-gray-600">' . $res[0]->phone . '</p></div></div></a>';
        }

        return $html;
    }

    public function getDistance($lat, $long)
    {
        $mechs = User::with('addresses')->get();

        $headURL = $this->baseURL.'/Routes/DistanceMatrix?origins='.$lat.','.$long;
        $bodyURL = '&destinations=';
        $tailURL = "&travelMode=driving&output=json&key=".$this->BingMapsKey;

        $results = [];

        foreach ($mechs as $mech) {


            if (!isset($mech->addresses[0])) {
                continue;
            }

            $url = $headURL . $bodyURL . $mech->addresses[0]->address_latitude . ',' .$mech->addresses[0]->address_longitude;
            $url .= $tailURL;

            $output = file_get_contents($url);
            $phpArray = json_decode($output, true);

            $distance = $phpArray['resourceSets'][0]['resources'][0]['results'][0]['travelDistance'];


            if ($distance < 10) {
                array_push($results, array($mech, $distance));
            }
        }

        return $results;
    }
}