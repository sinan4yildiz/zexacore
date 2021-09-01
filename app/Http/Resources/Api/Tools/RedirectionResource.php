<?php

namespace App\Http\Resources\Api\Tools;

use Illuminate\Http\Resources\Json\JsonResource;

class RedirectionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'from'           => $this->from,
            'to'             => $this->to,
            'count'          => number_format($this->count),
            'updated_at'     => $this->updated_at ? $this->updated_at->diffForHumans() : null,
            'updated_at_raw' => $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null,
        ];
    }
}