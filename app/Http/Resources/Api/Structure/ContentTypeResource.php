<?php

namespace App\Http\Resources\Api\Structure;

use Illuminate\Http\Resources\Json\JsonResource;

class ContentTypeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'translation'  => new ContentTypeTranslationResource($this->translation),
            'has_listing'  => $this->has_listing,
            'is_indexable' => $this->is_indexable,
            'sort_order'   => $this->sort_order,
            'is_active'    => $this->is_active,
            'translations' => ContentTypeTranslationResource::collection($this->translations),
        ];
    }
}