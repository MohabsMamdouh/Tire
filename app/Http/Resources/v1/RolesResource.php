<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

// Resources & Collection
use App\Http\Resources\v1\PermissionsResource;
use App\Http\Resources\v1\PermissionsCollection;

class RolesResource extends JsonResource
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
            'name' => $this->name,
            'guardName' => $this->guard_name,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'permissions' => new PermissionsResource($this->permission),
        ];
    }
}