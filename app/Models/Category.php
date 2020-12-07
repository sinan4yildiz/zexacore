<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function translation($language_code = null)
    {
        $translation = $this->hasOne(CategoryTranslation::class)->where('language_code', $language_code ?? config('settings.default_language_code'));

        return $language_code ? $translation->first() : $translation;
    }

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class, 'category_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function parents($itself = true)
    {
        $parents = collect([]);
        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent->translation);
            $parent = $parent->parent;
        }

        if ($itself) {
            $parents->prepend($this->translation);
        }

        return $parents->reverse();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Category $category) {
            foreach ($category->children as $child) {
                $child->delete();
            }
        });
    }
}
