<?php

namespace App\Http\Resources\Api\Structure;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'              => $this->id,
            'translation'     => new CategoryTranslationResource($this->translation),
            'parent_id'       => $this->parent_id,
            'content_type_id' => $this->content_type_id,
            'sort_order'      => $this->sort_order,
            'is_active'       => $this->is_active,

            $this->mergeWhen($this->relationLoaded('parent'), [
                'parent' => new CategoryResource($this->parent),
            ]),

            $this->mergeWhen($this->with_parents, [
                'parents' => CategoryTranslationResource::collection($this->parents()),
            ]),

            $this->mergeWhen($this->relationLoaded('translations'), [
                'translations' => CategoryTranslationResource::collection($this->translations),
            ]),
        ];
    }
}