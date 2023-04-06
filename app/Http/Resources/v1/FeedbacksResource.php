<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\v1\VisitsResource;
use App\Http\Resources\v1\VisitsCollection;

use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\v1\CustomerCollection;

class FeedbacksResource extends JsonResource
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
            'message' => $this->message,
            'customerId' => $this->customer_id,
            'visitId' => $this->visit_id,
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'visit' => new VisitsResource($this->whenLoaded('visit')),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
        ];
    }
}