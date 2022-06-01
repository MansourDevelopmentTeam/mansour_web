<?php

namespace App\Http\Requests\Customer;

use App\Rules\PhoneValid;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "phone" => ["required", "numeric", new PhoneValid()],
            // "birthdate" => "required|before:" . date("Y-m-d"),
            "name" => "required",
            "closed_payment_methods" => "sometimes|array|exists:payment_methods,id",
        ];
    }
}
