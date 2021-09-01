<?php

namespace App\Http\Resources\Api\Tools;

use Illuminate\Http\Resources\Json\JsonResource;

class SlugResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'language_code' => $this->language_code,
            'url'           => env('APP_URL'),
            'keyword'       => $this->keyword,
            'module'        => basename($this->module),
        ];
    }
}