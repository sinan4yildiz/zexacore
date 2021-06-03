<?php

namespace App\Helpers;

class Breadcrumb
{
    static $items = [];

    public static function add($item)
    {
        static::$items[] = $item;
    }

    public static function check()
    {
        return count(static::$items);
    }

    public static function get()
    {
        array_unshift(static::$items, [
            'title' => trans('admin/common.dashboard'),
            'href'  => route('admin.dashboard')
        ]);

        return static::$items;
    }
}