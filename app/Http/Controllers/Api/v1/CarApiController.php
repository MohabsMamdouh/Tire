<?php

namespace App\Http\Controllers\Api\v1;

// Controllers
use App\Http\Controllers\Controller;
use App\Http\Controllers\CarController;

// Models
use App\Models\Car;

// Requests
use Illuminate\Http\Request;

// Resources & Collection
use App\Http\Resources\v1\CarsResource;
use App\Http\Resources\v1\CarsCollection;

// Filters
use App\Filters\V1\CarsFilter;

// Traits
use App\Traits\CarsTrait;


class CarApiController extends Controller
{
    use CarsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = new CarsFilter();

        $filterItmes = $filter->transform($request);

        $cars = Car::where($filterItmes);

        $carModels = $request->query('carModels');

        if ($carModels) {
            $cars->with('models');
        }

        return new CarsCollection($cars->paginate());
    }

    public function store(Request $request)
    {
        # code...
    }

    public function show(Car $car)
    {
        # code...
    }

    public function update(Request $request, Car $car)
    {
        # code...
    }

    public function destroy(Car $car)
    {
        # code...
    }

    public function updateCarList()
    {

        $api_url = (new CarController)->UrlAPi;

        // Read JSON file
        $json_data = file_get_contents($api_url);

        // Decode JSON data into PHP array
        $response_data = json_decode($json_data);

        $this->StoreCarName($response_data->records);

        $this->storeModelsSpecs($response_data->records);

        return [
            'status' => 200,
            'msg' => 'list updated successfully'
        ];
    }
}