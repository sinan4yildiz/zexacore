<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    public function translation()
    {
        return $this->hasOneThrough(
            Page::class,
            Relationship::class,
            'source_id',
            'id',
            'id',
            'target_id'
        )->where('key', config('constants.relationships.translation.page'))->where('value', config('settings.default_language_code'));
    }

    public function translations()
    {
        return $this->hasManyThrough(
            Page::class,
            Relationship::class,
            'source_id',
            'id',
            'id',
            'target_id'
        )->where('key', config('constants.relationships.translation.page'));
    }

    public static function attachTranslation($source_id, $target_id, $language_code)
    {
        if ($source_id != $target_id) {
            Relationship::updateOrCreate([
                'source_id' => $source_id,
                'target_id' => $target_id,
                'key'       => config('constants.relationships.translation.page'),
                'value'     => $language_code
            ]);
        }
    }

    public static function detachTranslation($item)
    {
        Relationship::where('source_id', $item->id)
            ->where('key', config('constants.relationships.translation.page'))
            ->orWhere('target_id', $item->id)
            ->delete();
    }

    public function slug($language_code)
    {
        return $this->hasOne(Slug::class, 'value', 'id')->where([
            ['language_code', $language_code],
            ['module', config('constants.slugs.module.page')],
        ])->first();
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($item) {
            static::detachTranslation($item);

            Slug::where([
                ['value', $item->id],
                ['module', config('constants.slugs.module.page')]
            ])->delete();
        });
    }
}