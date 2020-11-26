<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    public $timestamps = false;

    public function translation($language_id = null)
    {
        if ($language_id == null) {
            $language_id = 1;
        }
        return $this->hasOne(ContentTypeTranslations::class)->where('language_id', '=', $language_id);
    }
}
