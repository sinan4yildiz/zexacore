<?php

namespace App\Http\Resources\Api\System;

use Illuminate\Http\Resources\Json\JsonResource;

class LanguageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'native'     => $this->native,
            'code'       => $this->code,
            'locale'     => $this->locale,
            'sort_order' => $this->sort_order,
            'is_active'  => $this->is_active,
        ];
    }
}