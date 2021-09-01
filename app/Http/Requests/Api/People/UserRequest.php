<?php

namespace App\Http\Requests\Api\People;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     * Define validation rules to update method for resource update
     *
     * @return array
     *
     */
    public function updateRules(): array
    {
        return [
            'firstname' => 'required',
            'lastname'  => 'required',
            'password'  => 'nullable|min:6',
            'email'     => 'required|email|max:191|unique:users,email,' . $this->id
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
