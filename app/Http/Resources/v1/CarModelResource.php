<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\v1\CarsResource;
use App\Http\Resources\v1\CarsCollection;

class CarModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'model' => $this->model,
            'carId' => $this->car_id,
            'cylinders' => $this->cylinders,
            'drive' => $this->drive,
            'engDscr' => $this->eng_dscr,
            'fueltype' => $this->fueltype,
            'fueltype1' => $this->fueltype1,
            'mpgdata' => $this->mpgdata,
            'phevblended' => $this->phevblended,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'car' => new CarsResource($this->car),
        ];
    }
}
