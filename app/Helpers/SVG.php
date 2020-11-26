<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SVG
{
    public static function get($parameters)
    {
        $parameters = explode(',', $parameters);

        $file = resource_path('assets/admin/svg/' . head($parameters) . '.svg');

        if (!File::exists($file)) {
            Log::warning('SVG not found: ' . head($parameters));

            return false;
        }

        $source = Str::of(File::get($file))->replace('<svg', '<svg class="' . trim(end($parameters)) . '"');

        return $source;
    }

}