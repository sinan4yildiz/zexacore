<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SVG
{
    protected static $filename;
    protected static $subfolder = null;

    public static function icon(string $filename)
    {
        static::$subfolder = 'icons';

        return static::get($filename);
    }

    public static function flag(string $filename)
    {
        static::$subfolder = 'flags';

        return static::get($filename);
    }

    public static function file(string $filename)
    {
        return static::get($filename);
    }

    private static function get($filename)
    {
        static::$filename = $filename;

        $file = static::path(static::$filename);

        if (!File::exists($file)) {
            Log::warning('SVG not found: ' . $file);

            return false;
        }

        return File::get($file);
    }

    private static function path()
    {
        $path = 'assets/:admin/svg/:subfolder/:name.svg';

        $svg = preg_replace_array('/:[a-z_]+/', [
            env('APP_ADMIN_DIR'),
            static::$subfolder,
            static::$filename,
        ], $path);

        $resource = resource_path($svg);

        return Str::of($resource)->replace('//', '/');
    }
}