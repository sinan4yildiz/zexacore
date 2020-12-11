<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
            'firstname' => 'required',
            'lastname'  => 'required',
            'password'  => 'required|min:6',
            'email'     => 'required|string|email|max:191|unique:users,email'
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
        }
    }
}
