<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,

            // Include the permissions associated with the user
            // Use PermissionResource to transform each permission in the permission list
            // Map through the permissions to return only specific fields: 'id' and 'name'
            'permissions' => PermissionResource::collection($this->permissionList())->map(function ($permissionResource) {
                return $permissionResource->only(['id', 'name']);
            }),

            // Include the roles associated with the user
            // Use RoleResource to transform each role in the role list
            // Map through the roles and hide unnecessary fields like 'created_at' and 'updated_at'
            "roles" => RoleResource::collection($this->roleList())->map(function ($roleResource) {
                return $roleResource->hide([
                    "created_at",
                    "updated_at",

                ]);
            }),
            'user_type' => $this->user_type,
            // 'created_at' => $this->created_at->toDateTimeString(),
            // 'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
