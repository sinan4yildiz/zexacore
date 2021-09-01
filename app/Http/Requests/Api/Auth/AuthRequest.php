<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class AuthRequest extends FormRequest
{
    /**
     * Define validation rules to the login method
     *
     * @return array
     *
     */
    public function loginRules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required|string',
        ];
    }

    /**
     * Apply rules by action method
     *
     * @return array
     *
     */
    public function rules()
    {
        $actionMethod = Route::getCurrentRoute()->getActionMethod();

        switch ($actionMethod) {
            case 'login':
                return $this->loginRules();
            break;
        }
    }

}
