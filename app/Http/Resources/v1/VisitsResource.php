<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\v1\CustomerResource;
use App\Http\Resources\v1\CustomerCollection;

use App\Http\Resources\v1\CarModelResource;
use App\Http\Resources\v1\CarModelCollection;

use App\Http\Resources\v1\FeedbacksResource;
use App\Http\Resources\v1\FeedbacksCollection;

// use App\Http\Resources\v1\UsersResource;
// use App\Http\Resources\v1\UsersCollection;

class VisitsResource extends JsonResource
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
            'customerId' => $this->customer_id,
            'reason' => $this->reason,
            'userId' => $this->user_id,
            'carModelId' => $this->car_model_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'customer' => new CustomerResource($this->customer),
            'model' => new CarModelResource($this->model),
            'user' => new UsersResource($this->user),
            'feedbacks' => FeedbacksResource::collection($this->whenLoaded('feedbacks')),
        ];
    }
}