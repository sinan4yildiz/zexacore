<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\File;

class FolderExists implements Rule
{
    protected $dir = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($dir = null)
    {
        $this->dir = $dir;
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
        if (File::exists($this->dir . $value)) {
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
