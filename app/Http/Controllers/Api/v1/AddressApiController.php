<?php

namespace App\Http\Controllers\Api\v1;

// Controller
use App\Http\Controllers\Controller;

// Requests
use Illuminate\Http\Request;

// Models
use App\Models\Address;
use App\Models\User;

// Resources & Collections
use App\Http\Resources\v1\AddressResource;
use App\Http\Resources\v1\AddressCollection;

class AddressApiController extends Controller
{

    private $BingMapsKey = 'Ag0mGd-pnqRtYoueECNNzDNwARA_yN-agnPrcMzrVPsG3piMytyERDlXfkRhnmwQ';

    private $baseURL = "https://dev.virtualearth.net/REST/v1";

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $findURL = $this->baseURL.'/Locations/'.$request['latitude'].','.$request['longitude']."?key=".$this->BingMapsKey;

        $output = file_get_contents($findURL);

        $phpArray = json_decode($output, true);

        $addressDetails = $phpArray['resourceSets'][0]['resources'][0]['address'];

        $userAdd = Address::where('user_id', $request['userId'])->get();

        if(count($userAdd) == 0) {
            $address = Address::create([
                'user_id' => $request['userId'],
                'address_address' => $addressDetails['formattedAddress'],
                'address_latitude' => $request['latitude'],
                'address_longitude' => $request['longitude'],
                'address_ZipCode' => 17774,
            ]);
        } else {
            $address = Address::update([
                'user_id' => $request['userId'],
                'address_address' => $addressDetails['formattedAddress'],
                'address_latitude' => $request['latitude'],
                'address_longitude' => $request['longitude'],
                'address_ZipCode' => 17774,
            ]);
        }

        return [
            'status' => 200,
            'adddress' => new AddressResource($address->user),
        ];
    }


    public function near(Request $request)
    {
        $results = $this->getDistance($request->get('lat'), $request->get('long'));

        return $results;
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
                array_push($results, ["mechanic" => $mech, "distance" => $distance]);
            }
        }

        return $results;
    }
}