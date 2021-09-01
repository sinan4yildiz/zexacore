<?php

namespace App\Http\Middleware\Api;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        /**
         * Go to exception handler to modify
         *
         * App\Exceptions\Handler
         */
        return response()->json(['errors' => [trans('api/common.auth.required')]], 401);
    }
}
