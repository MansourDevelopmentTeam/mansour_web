<?php

namespace App\Http\Requests\Customer;

use App\Rules\PhoneVerified;
use Illuminate\Foundation\Http\FormRequest;

class PrescriptionRequest extends FormRequest
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
            // "name" => "required",
            "address_id" => "required|exists:addresses,id",
            "images" => "required|array",
            "phone_verified" => new PhoneVerified
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'phone_verified' => null,
        ]);
    }
}
