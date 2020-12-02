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
            'title'             => $this->translation->title ?? trans('admin/common.no_translation'),
            'description'       => $this->translation->description ?? null,
            'description_plain' => Str::limit(strip_tags($this->translation->description ?? null), 140),
            'meta_title'        => $this->translation->meta_title ?? null,
            'meta_description'  => $this->translation->meta_description ?? null,
            'meta_keywords'     => $this->translation->meta_keywords ?? null,
            'slug'              => $this->slug->keyword ?? null,
            'has_listing'       => $this->has_listing,
            'is_indexable'      => $this->is_indexable,
            'sort_order'        => $this->sort_order,
            'is_active'         => $this->is_active,
        ];
    }
}