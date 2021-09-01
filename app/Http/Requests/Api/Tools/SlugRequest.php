<?php

namespace App\Http\Requests\Api\Tools;

use Illuminate\Foundation\Http\FormRequest;

class SlugRequest extends FormRequest
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
            'keyword' => 'required|unique:slugs,keyword,' . $this->id . ',id,language_code,' . $this->language_code,
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
