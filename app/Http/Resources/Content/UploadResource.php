<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
        ];
    }
}

