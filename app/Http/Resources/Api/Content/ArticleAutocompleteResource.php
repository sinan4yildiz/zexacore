<?php

namespace App\Http\Resources\Api\Content;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleAutocompleteResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'value' => $this->id,
            'text'  => $this->title,
        ];
    }
}