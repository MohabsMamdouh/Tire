<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

// Resources & Collection
use App\Http\Resources\v1\VisitsResource;
use App\Http\Resources\v1\VisitsCollection;

use App\Http\Resources\v1\RolesResource;
use App\Http\Resources\v1\RolesCollection;

use App\Http\Resources\v1\AddressResource;
use App\Http\Resources\v1\AddressCollection;

class UsersResource extends JsonResource
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
            'fname' => $this->fname,
            'email' => $this->email,
            'username' => $this->username,
            'phone' => $this->phone,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'visits' => VisitsResource::collection($this->whenLoaded('visits')),
            'roles' => RolesResource::collection($this->whenLoaded('roles')),
            'address' => AddressResource::collection($this->whenLoaded('addresses')),
        ];
    }
}
