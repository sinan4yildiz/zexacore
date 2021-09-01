<?php

namespace App\Http\Resources\Api\People;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'firstname'      => $this->firstname,
            'lastname'       => $this->lastname,
            'title'          => $this->title,
            'email'          => $this->email,
            'is_active'      => $this->is_active,
            'created_at'     => $this->created_at->diffForHumans(),
            'created_at_raw' => $this->created_at->format('d F Y, H:i'),
            'updated_at'     => $this->updated_at ? $this->updated_at->diffForHumans() : null,
            'updated_at_raw' => $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null,
        ];
    }
}

