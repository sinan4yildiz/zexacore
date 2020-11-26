<?php

namespace App\Http\Resources\Structure;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ContentTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'title'             => $this->translation->title,
            'description'       => $this->translation->description,
            'description_plain' => Str::limit(strip_tags($this->translation->description), 140),
            'meta_title'        => $this->translation->meta_title,
            'meta_description'  => $this->translation->meta_description,
            'meta_keywords'     => $this->translation->meta_keywords,
            'sort_order'        => $this->sort_order,
            'is_active'         => $this->is_active,
        ];
    }
}