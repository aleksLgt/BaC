<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InputGameUniqueRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $digits = array_unique(str_split($value));
        return count($digits) == 4;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '4 non-repeating digits are needed';
    }
}
