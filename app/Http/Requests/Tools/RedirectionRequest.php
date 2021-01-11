<?php

namespace App\Http\Requests\Tools;

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
            'to'   => 'required',
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
            'from' => 'required|string|unique:redirections,from,' . $this->id,
            'to'   => 'required',
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
