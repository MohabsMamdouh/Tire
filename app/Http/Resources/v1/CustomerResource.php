<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

use App\Http\Resources\v1\CarModelResource;
use App\Http\Resources\v1\CarModelCollection;

use App\Http\Resources\v1\VisitsResource;
use App\Http\Resources\v1\VisitsCollection;

use App\Http\Resources\v1\FeedbacksResource;
use App\Http\Resources\v1\FeedbacksCollection;

class CustomerResource extends JsonResource
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
            'customerFname' => $this->customer_fname,
            'customerAddress' => $this->customer_address,
            'email' => $this->email,
            'customerUsername' => $this->customer_username,
            'customerPhone' => $this->customer_phone,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'models' => CarModelResource::collection($this->whenLoaded('models')),
            'visits' => VisitsResource::collection($this->whenLoaded('visits')),
            'feedbacks' => FeedbacksResource::collection($this->whenLoaded('feedbacks')),
        ];
    }
}