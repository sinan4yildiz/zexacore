<?php

namespace App\Http\Resources\Api\Content;

use App\Http\Resources\Api\Structure\CategoryTranslationResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Finder\Finder;

class ArticleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'content'          => $this->content,
            'image'            => $this->image,
            'slug'             => $this->slug($this->language_code)->keyword ?? null,
            'meta_title'       => $this->meta_title,
            'meta_description' => $this->meta_description,
            'meta_keywords'    => $this->meta_keywords,
            'type'             => $this->type,
            'language_code'    => $this->language_code,
            'content_type_id'  => $this->content_type_id,
            'translations'     => $this->translations,
            'views'            => number_format($this->views),
            'status'           => $this->status,
            'is_active'        => $this->is_active,
            'is_indexable'     => $this->is_indexable,
            'created_at'       => $this->created_at->diffForHumans(),
            'created_at_raw'   => $this->created_at->format('d F Y, H:i'),
            'updated_at'       => $this->updated_at ? $this->updated_at->diffForHumans() : null,
            'updated_at_raw'   => $this->updated_at ? $this->updated_at->format('d/m/Y H:i') : null,

            $this->mergeWhen($this->image, [
                'thumbnail' => new UploadResource(collect((new Finder())->in(config('filesystems.disks.uploads.root'))->path($this->image))->first()),
            ]),

            $this->mergeWhen($this->relationLoaded('translation'), [
                'translation' => $this->translation,
            ]),

            $this->mergeWhen($this->relationLoaded('category'), [
                'category' => $this->category,
            ]),

            $this->mergeWhen($this->relationLoaded('categories'), [
                'categories' => $this->categories,
            ]),
        ];
    }
}

