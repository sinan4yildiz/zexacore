<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $token;

    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Authenticate the user
     *
     * @param  \App\Http\Requests\Api\Auth\AuthRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(AuthRequest $request)
    {
        $rules = [
            'email'     => $request->email,
            'password'  => $request->password,
            'is_active' => true
        ];

        if (!$this->token = auth('api')->attempt($rules)) {
            return response()->json(['error' => trans('api/common.auth.failed')], 401);
        }

        return $this->essential();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => trans('api/common.auth.logout')]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify()
    {
        return $this->essential();
    }

    /**
     * Return the essential data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function essential()
    {
        return response()->json([
            'token'    => $this->token ?? JWTAuth::getToken()->get(),
            /*'expires_in' => auth('api')->factory()->getTTL() * 60,*/
            'user'     => auth('api')->user(),
            'settings' => config('settings')
        ]);
    }

}
