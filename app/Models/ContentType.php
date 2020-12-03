<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function translation($language_code = null)
    {
        $translation = $this->hasOne(ContentTypeTranslation::class)->where('language_code', $language_code ?? config('settings.default_language_code'));

        return $language_code ? $translation->first() : $translation;
    }

    public function translations()
    {
        return $this->hasMany(ContentTypeTranslation::class, 'content_type_id');
    }
}
