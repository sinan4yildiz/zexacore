<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function translation($language_id = null)
    {
        $translation = $this->hasOne(ContentTypeTranslation::class)->where('language_id', $language_id ?? config('settings.default_language_id'));

        return $language_id ? $translation->first() : $translation;
    }

    public function slug($language_id = null)
    {
        $slug = $this->hasOne(Slug::class, 'value')->where([
            ['language_id', $language_id ?? config('settings.default_language_id')],
            ['query', config('constant.slugs.paths.content_types')],
        ]);

        return $language_id ? $slug->first() : $slug;
    }
}
