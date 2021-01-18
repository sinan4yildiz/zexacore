<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    public function translation($language_code)
    {
        return $this->hasOne(Relationship::class)->where('value', $language_code)->first();
    }

    public function translations()
    {
        return $this->hasMany(Relationship::class, 'sid')->where('key', config('constants.relationships.translation.page'));
    }
}
