<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentTypeTranslations extends Model
{
    public $timestamps = false;

    public function contentType()
    {
        return $this->belongsTo(ContentType::class);
    }
}