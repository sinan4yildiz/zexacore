<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class AppController extends Controller
{
    public function index()
    {
        /**
         * System settings
         *
         */
        $settings = Setting::all()->pluck('value', 'key');


        return view('admin.app', [
            'settings' => $settings
        ]);
    }
}
