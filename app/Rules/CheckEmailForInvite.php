<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class CheckEmailForInvite implements Rule
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
        $isPrerregistered = User::where('is_active', 0)->where('email', $value)->first() ?? false;

        if ($isPrerregistered) {
            return true;
        }

        //else
        $alreadyExists = User::where('email', $value)->first() ?? false;

        if ($alreadyExists) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This email is not available';
    }
}
