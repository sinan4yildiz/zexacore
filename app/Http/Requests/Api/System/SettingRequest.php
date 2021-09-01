<?php

namespace App\Http\Requests\Api\System;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     *
     */
    public function updateRules(): array
    {
        return [
            'brand_name'            => 'sometimes|required',
            'company_name'          => 'sometimes|required',
            'email_address'         => 'sometimes|required|string|email|max:191',
            'default_language_code' => 'sometimes|required|exists:languages,code'
        ];
    }

    /**
     * Apply rules by request method
     *
     * @return array
     *
     */
    public function rules()
    {
        if ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }
}
