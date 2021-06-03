<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\File;

class FileExists implements Rule
{
    protected $filepath = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($filepath)
    {
        $this->filepath = $filepath;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (File::exists($this->filepath)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.exists');
    }
}
