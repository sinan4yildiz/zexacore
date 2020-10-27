<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{

    public function index()
    {
        return view('admin.auth.login.index');
    }

    public function attempt(Request $request)
    {
        $request->flashExcept(['password']);

        $request->validate([
            'method'   => 'required',
            'password' => 'required',
        ]);

        $login_credentials = [
            'email'     => $request->input('method'),
            'username'  => $request->input('method'),
            'password'  => $request->input('password'),
            'is_active' => 1,
        ];

        if (filter_var($request->input('method'), FILTER_VALIDATE_EMAIL)) {
            unset($login_credentials['username']);
        } else {
            unset($login_credentials['email']);
        }

        if (Auth::guard('admin')->attempt($login_credentials)) {
            return redirect()->intended(route('admin'));
        } else {
            return back()->withErrors(['credentials' => trans('admin/modules/auth/login.error_invalid_credentials')]);
        }
    }
}