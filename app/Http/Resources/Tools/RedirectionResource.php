<?php

namespace App\Http\Resources\Tools;

use Illuminate\Http\Resources\Json\JsonResource;

class RedirectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'from'           => $this->from,
            'to'             => $this->to,
            'count'          => $this->count,
            'updated_at'     => $this->updated_at->diffForHumans(),
            'updated_at_raw' => $this->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}