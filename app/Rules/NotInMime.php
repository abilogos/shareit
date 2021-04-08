<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Concerns\ValidatesAttributes;

class NotInMime implements Rule
{
    /**
     * This Validation Rules checks The Under Validation Input Shouldnt Follow specific mime types
     */

    //for using validateMimes() method. using this trait from Laravel
    use ValidatesAttributes;

    /**
     * Create a new rule instance and setting rule parameters.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Determine if the validation rule passes.
     *
     * The Field Should Has Not $params MimeType
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // validateMimes() from ValidatesAttributes Trait will check for certain mimetypes.
        // we just need to invert it.
        return !$this->validateMimes($attribute, $value, $this->params);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This :attribute mimetype is not acceptale';
    }
}
