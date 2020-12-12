<?php

namespace App\Helpers;

class Helper
{

    /**
     * Readable file size for humans
     *
     */
    public static function sizeForHuman($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}