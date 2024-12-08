<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
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
            'details'    => $this->details,
            'status'     => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
