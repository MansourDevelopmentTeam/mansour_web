<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneVerified implements Rule
{
    /**
     * Message to display when the validation fails.
     *
     * @var string
     */
    protected $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = auth()->user();
        // dd($user);

        // Check user has phone
        if (!$user->phone) {
            $this->message = trans('mobile.user_has_invalid_phone');
            return false;
        }
        // Check user has phone verified
        if (!$user->phone_verified) {
            $this->message = trans("mobile.errorUpdateApp");
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
        return $this->message;
    }
}
