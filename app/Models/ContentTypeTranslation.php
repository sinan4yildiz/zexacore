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
            ['module', config('constants.slugs.module.content_type')],
        ])->first();
    }
}