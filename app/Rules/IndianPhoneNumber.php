<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class IndianPhoneNumber implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Regular expression to match +91 and 10 digits
        return preg_match('/^\+91[6-9]\d{9}$/', $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid Indian phone number with the +91 country code.';
    }

}
