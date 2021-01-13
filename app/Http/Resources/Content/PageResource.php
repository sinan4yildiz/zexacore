<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'content'          => $this->content,
            'image'            => $this->image,
            'meta_title'       => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords'    => $this->meta_keywords,
            'type'             => $this->type,
            'language_code'    => $this->language_code,
            'views'            => $this->views,
            'status'           => $this->status,
            'is_indexable'     => $this->is_indexable,
            'created_at'       => $this->created_at->diffForHumans(),
            'created_at_raw'   => $this->created_at->format('d/m/Y H:i:s'),
            'updated_at'       => $this->updated_at->diffForHumans(),
            'updated_at_raw'   => $this->updated_at->format('d/m/Y H:i:s'),
        ];
    }
}

