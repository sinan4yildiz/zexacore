<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Logout extends Controller
{

    public function index(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->flush();
        $request->session()->regenerate();

        return redirect()->route('admin.auth.login');
    }
}