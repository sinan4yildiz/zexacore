<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes, HasFactory;

    public function translation()
    {
        return $this->hasOneThrough(
            Article::class,
            Relationship::class,
            'source_id',
            'id',
            'id',
            'target_id'
        )->where('key', config('constants.relationships.translation.article'))->where('value', config('settings.default_language_code'));
    }

    public function translations()
    {
        return $this->hasManyThrough(
            Article::class,
            Relationship::class,
            'source_id',
            'id',
            'id',
            'target_id'
        )->where('key', config('constants.relationships.translation.article'));
    }

    public function category()
    {
        return $this->hasOneThrough(
            CategoryTranslation::class,
            Relationship::class,
            'source_id',
            'category_id',
            'id',
            'target_id'
        )->where('key', config('constants.relationships.category.article'))
            ->where('language_code', config('settings.default_language_code'))
            ->orderBy('relationships.id', 'ASC');
    }

    public function categories()
    {
        return $this->hasManyThrough(
            CategoryTranslation::class,
            Relationship::class,
            'source_id',
            'category_id',
            'id',
            'target_id'
        )->where('key', config('constants.relationships.category.article'))
            ->where('language_code', config('settings.default_language_code'));
    }

    public static function attachTranslation($source_id, $target_id, $language_code)
    {
        if ($source_id != $target_id) {
            Relationship::updateOrCreate([
                'source_id' => $source_id,
                'target_id' => $target_id,
                'key'       => config('constants.relationships.translation.article'),
                'value'     => $language_code
            ]);
        }
    }

    public static function detachTranslation($item)
    {
        Relationship::where('source_id', $item->id)
            ->where('key', config('constants.relationships.translation.article'))
            ->orWhere('target_id', $item->id)
            ->delete();
    }

    public function slug($language_code)
    {
        return $this->hasOne(Slug::class, 'value', 'id')->where([
            ['language_code', $language_code],
            ['module', config('constants.slugs.module.article')],
        ])->first();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {
            static::detachTranslation($item);

            Slug::where([
                ['value', $item->id],
                ['module', config('constants.slugs.module.article')]
            ])->delete();
        });
    }
}