<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentTypeTranslation extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function slug($language_code)
    {
        return $this->hasOne(Slug::class, 'value', 'content_type_id')->where([
            ['language_code', $language_code],
            ['query', config('constant.slugs.paths.content_types')],
        ])->first();
    }
}