<?php

namespace App\Http\Resources\Api\Structure;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryAutocompleteResource extends JsonResource
{
    public function toArray($request)
    {
        $parents = $this->parents(false)->map(function ($parent) {
            return [
                'id'   => $parent->id,
                'text' => $parent->title
            ];
        });

        return [
            'value'   => $this->id,
            'text'    => $this->translation->title,
            'parents' => $parents,
        ];
    }
}