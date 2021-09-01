<?php

namespace App\Http\Resources\Api\Tools;

use Illuminate\Http\Resources\Json\JsonResource;

class NotFoundResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'uri'            => $this->uri,
            'count'          => number_format($this->count),
            'redirection'    => $this->redirection,
            'updated_at'     => $this->updated_at ? $this->updated_at->diffForHumans() : null,
            'updated_at_raw' => $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null,
        ];
    }
}