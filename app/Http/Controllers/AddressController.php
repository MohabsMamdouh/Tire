<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;


class AddressController extends Controller
{
    private $countries = array(
        array('AR', 'Argentina'),
        array('AU','Australia'),
        array('AT','Austria'),
        array('BH', 'Bahrain'),
        array('BY', 'Belarus'),
        array('BE', 'Belgium'),
        array('BZ','Belize' ),
        array('BR', 'Brazil'),
        array('bn', 'Brunei'),
        array('bg', 'Bulgaria'),
        array('ca', 'Canada'),
        array('cl', 'Chile'),
        array('cn', 'China'),
        array('co', 'Colombia'),
        array('cr', 'Costa Rica'),
        array('hr', 'Croatia'),
        array('cy', 'Cyprus'),
        array('cz', 'Czech Republic'),
        array('dk', 'Denmark'),
        array('do', 'Dominican Republic'),
        array('ec', 'Ecuador'),
        array('eg', 'Egypt'),
        array('sv', 'El Salvador'),
        array('ee', 'Estonia'),
        array('fi', 'Finland'),
        array('fr', 'France'),
        array('ge', 'Georgia'),
        array('de', 'Germany'),
        array('gr', 'Greece'),
        array('gu', 'Guam'),
        array('gt', 'Guatemala'),
        array('hn', 'Honduras'),
        array('hk', 'Hong Kong SAR'),
        array('hu', 'Hungary'),
        array('in', 'India'),
        array('id', 'Indonesia'),
        array('ie', 'Ireland'),
        array('im', 'Isle of Man'),
        array('il', 'Israel'),
        array('it', 'Italy'),
        array('jp', 'Japan'),
        array('je', 'Jersey'),
        array('kr', 'Korea'),
        array('kg', 'Kyrgyzstan'),
        array('lb', 'Lebanon'),
        array('lt', 'Lithuania'),
        array('mk', 'Macedonia'),
        array('my', 'Malaysia'),
        array('mt', 'Malta'),
        array('mu', 'Mauritius'),
        array('mx', 'Mexico'),
        array('mn', 'Mongolia'),
        array('mm', 'Myanmar'),
        array('np', 'Nepal'),
        array('nl', 'Netherlands'),
        array('nz', 'New Zealand'),
        array('ni', 'Nicaragua'),
        array('ng', 'Nigeria'),
        array('no', 'Norway'),
        array('pk', 'Pakistan'),
        array('pe', 'Peru'),
        array('pl', 'Poland'),
        array('pt', 'Portugal'),
        array('ph', 'Republic of the Philippines'),
        array('re', 'Reunion'),
        array('ro', 'Romania'),
        array('ru', 'Russia'),
        array('sa', 'Saudi Arabia'),
        array('sn', 'Senegal'),
        array('sr-latn-rs', 'Serbia'),
        array('rs', 'Serbia'),
        array('sc', 'Seychelles'),
        array('sg', 'Singapore'),
        array('si', 'Slovenia'),
        array('za', 'South Africa'),
        array('es', 'Spain'),
        array('lk', 'Sri Lanka'),
        array('se', 'Sweden'),
        array('ch', 'Switzerland'),
        array('tw', 'Taiwan'),
        array('th', 'Thailand'),
        array('tt', 'Trinidad and Tobago'),
        array('tr', 'Turkey'),
        array('ae', 'United Arab Emirates'),
        array('uk', 'United Kingdom'),
        array('gb', 'United Kingdom'),
        array('us',' United States'),
        array('um', 'United States Minor Outlying Islands'),
        array('ve', 'Venezuela'),
        array('vn', 'Vietnam'),
        array('ye', 'Yemen'),
        array('yu', 'Yugoslavia'),
        array('zw', 'Zimbabwe'),
    );

    private $BingMapsKey = 'Ag0mGd-pnqRtYoueECNNzDNwARA_yN-agnPrcMzrVPsG3piMytyERDlXfkRhnmwQ';


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
        $countries = $this->countries;
        $BingMapsKey = $this->BingMapsKey;

        // dd(count($countries));
        return view('address.create', compact('countries', 'BingMapsKey'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd( $_SERVER['HTTP_CLIENT_IP']);


        // $ip = $request->ip(); /* Dynamic IP address */
        // $ip = '162.159.24.227'; /* Static IP address */
        // $currentUserInfo = Location::get('192.168.1.11');

        $position = Location::get();
        dd($position);

        // $data = \Location::get($ipaddress);
        // return view('details',compact('data'));


        // May Use to get the nerest shop to customer
        // $user_ip = getenv('REMOTE_ADDR');
        // $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));
        // $country = $geo["geoplugin_countryName"];
        // $city = $geo["geoplugin_city"];

        // dd($geo);





        // Get lat and long by address
        // $BingMapsKey = $this->BingMapsKey;


        // // URL of Bing Maps REST Services Locations API
        // $baseURL = "http://dev.virtualearth.net/REST/v1/Locations";

        // // Create variables for search parameters (encode all spaces by specifying '%20' in the URI)
        // // http://dev.virtualearth.net/REST/v1/Locations/US/NY/10007/New York/291 Broadway?output=xml&key=yourKeyHere
        // // http://dev.virtualearth.net/REST/v1/Locations/countryRegion/adminDistrict/postalCode/locality/addressLine?key=yourBingMapsKey

        // $key = $BingMapsKey;
        // $country = $request['Country_name']; // US
        // $adminDistrict = str_ireplace(" ","%20",$request['State_name']); // NY
        // $postalCode = str_ireplace(" ","%20",$request['zip_code']); // 10007
        // $locality = str_ireplace(" ","%20",$request['City_name']); // New York
        // $addressLine = str_ireplace(" ","%20",$request['street_name']); // 291 Broadway

        // // Compose URI for Locations API request
        // $findURL = $baseURL."/".$country."/".$adminDistrict."/".$postalCode."/".$locality."/".$addressLine."?output=xml&key=".$key;

        // // get the response from the Locations API and store it in a string
        // $output = file_get_contents($findURL);


        // $xmlObject = simplexml_load_string($output);

        // $json = json_encode($xmlObject);
        // $phpArray = json_decode($json, true);

        // dd($phpArray);

        // dd($phpArray['ResourceSets']['ResourceSet']['Resources']['Location']['GeocodePoint'][0]);


        // array:4 [▼ // app\Http\Controllers\AddressController.php:167
        //     "Latitude" => "40.714912"
        //     "Longitude" => "-74.006017"
        //     "CalculationMethod" => "Rooftop"
        //     "UsageType" => "Display"
        // ]


        // abort_unless(\Gate::allows('company_create'), 403);
        // $add = Address::create($request->all());
        // return redirect()->route('dashboard');
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