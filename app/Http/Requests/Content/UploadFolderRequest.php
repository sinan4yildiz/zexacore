<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\FolderExists;

class UploadFolderRequest extends FormRequest
{
    /**
     * Define validation rules to create method for resource creation
     *
     * @return array
     *
     */
    public function createRules(): array
    {
        $directory = public_path('uploads/');

        if ($this->dir) {
            $directory .= $this->dir . '/';
        }

        return [
            'name' => [
                'required',
                new FolderExists($directory),
            ]
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
