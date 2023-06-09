<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CarsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'carName' => $this->car_name,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'models' => CarModelResource::collection($this->whenLoaded('models')),
        ];
    }
}
