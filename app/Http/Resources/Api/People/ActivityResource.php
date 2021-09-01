<?php

namespace App\Http\Resources\Api\People;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'user'           => $this->user,
            'description'    => $this->description,
            'created_at'     => $this->created_at->diffForHumans(),
            'created_at_raw' => $this->created_at->format('d F Y, H:i'),
        ];
    }
}

