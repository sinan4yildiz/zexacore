<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HttpsHandler
{
    /**
     * Handle https protocol.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (env('APP_SSL') and !$request->secure()) {
            return redirect(url()->secure($request->getPathInfo()), 301);
        }

        return $next($request);
    }
}
