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
            'files.*' => 'mimes:jpg,jpeg,png,svg,pdf,doc,docx,xls,xlsx,rtf,csv,txt,rar,zip,ppt,pptx,xml'
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
