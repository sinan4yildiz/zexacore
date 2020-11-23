<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function index()
    {
        return view('admin.app');
    }
}
