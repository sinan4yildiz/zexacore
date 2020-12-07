<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function slug($language_code)
    {
        return $this->hasOne(Slug::class, 'value', 'category_id')->where([
            ['language_code', $language_code],
            ['query', config('constant.slugs.path.category')],
        ])->first();
    }
}