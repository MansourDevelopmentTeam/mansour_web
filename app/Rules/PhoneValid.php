<?php

namespace App\Rules;

use App\Models\Localization\Country;
use Illuminate\Contracts\Validation\Rule;
use function GuzzleHttp\Psr7\str;

class PhoneValid implements Rule
{
    public $message;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $localization = Country::where('country_code', config('app.country_code'))->first();
        if (!$localization) {
            $localization = Country::where('fallback', true)->first();
        }
        $pattern = $localization->phone_pattern;
        $phoneLength = $localization->phone_length;
//        $phonePattern = $localization->phone_pattern;
//        $phoneValidation = ['required', 'min:' . $phoneLength, 'max:' . $phoneLength, 'regex:/' . $phonePattern . '/u'];
        $patternValidation = (bool)preg_match("/{$pattern}/", $value);
        if (!$patternValidation) {
            $this->message = trans('mobile.phone_invalid');
            return false;
        }
        if ($phoneLength !== strlen($value)) {
            $this->message = trans('mobile.invalid_phone_length', ['length' => $phoneLength]);
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
