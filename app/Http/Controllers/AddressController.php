<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;


class AddressController extends Controller
{
    private $BingMapsKey = 'Ag0mGd-pnqRtYoueECNNzDNwARA_yN-agnPrcMzrVPsG3piMytyERDlXfkRhnmwQ';

    private $baseURL = "http://dev.virtualearth.net/REST/v1/Locations/";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'countries' => $this->countries,
            'BingMapKey' => $this->BingMapsKey,
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

        $findURL = $this->baseURL.$request['latitude'].','.$request['longitude']."?key=".$this->BingMapsKey;

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
            $address->save();

        return redirect()->back()->with('status', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAddressRequest  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}