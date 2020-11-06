<?php

namespace App\Http\Resources\People;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'firstname'      => $this->firstname,
            'lastname'       => $this->lastname,
            'title'          => $this->title,
            'email'          => $this->email,
            'is_active'      => $this->is_active,
            'created_at'     => $this->created_at->diffForHumans(),
            'created_at_raw' => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at'     => $this->updated_at->diffForHumans(),
            'updated_at_raw' => $this->updated_at,
        ];
    }
}

