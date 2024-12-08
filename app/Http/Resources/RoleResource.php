<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function hide(array $fields)
    {
        $this->resource->makeHidden($fields);
        return $this;
    }

    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            // Include the permissions associated with the role
            // Use PermissionResource to transform each permission in the permission list
            // Map through the permissions to return only specific fields: 'id' and 'name'
            'permissions' => PermissionResource::collection($this->permissionList())->map(function ($permissionResource) {
                return $permissionResource->only(['id', 'name']);
            }),
            'details'    => $this->details,
            'status'     => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
