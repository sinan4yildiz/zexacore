<?php

namespace App\Http\Requests\Api\Tools;

use Illuminate\Foundation\Http\FormRequest;

class RedirectionRequest extends FormRequest
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
            'from' => 'required|string|unique:redirections,from',
            'to'   => 'required|url',
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
            'to' => 'required|url',
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
