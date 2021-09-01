<?php

namespace App\Http\Requests\Api\System;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    /**
     * Define validation rules to create method for resource creation
     *
     * @return array
     *
     */
    public function createRules(): array
    {
        return [
            'name'   => 'required',
            'native' => 'required',
            'code'   => 'required',
            'locale' => 'required',
        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     *
     */
    public function updateRules(): array
    {
        return [
            'name'   => 'required',
            'native' => 'required',
            'code'   => 'required',
            'locale' => 'required',
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }
}
