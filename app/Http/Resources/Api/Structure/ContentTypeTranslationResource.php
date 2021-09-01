<?php

namespace App\Http\Resources\Api\Structure;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ContentTypeTranslationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'language_code'     => $this->language_code,
            'title'             => $this->title ?? trans('admin/common.no_translation'),
            'description'       => $this->description,
            'description_plain' => Str::limit(strip_tags($this->description), 140),
            'meta_title'        => $this->meta_title,
            'meta_description'  => $this->meta_description,
            'meta_keywords'     => $this->meta_keywords,
            'slug'              => $this->slug($this->language_code)->keyword ?? null,
        ];
    }
}