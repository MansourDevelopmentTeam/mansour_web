<?php

namespace App\Http\Requests\Customer;

use App\Models\Users\User;
use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
        $rules = [
            "name" => "required",
            "city_id" => "required|exists:cities,id",
            "area_id" => "sometimes|nullable|exists:areas,id",
            "district_id" => "sometimes|nullable|exists:districts,id",
            "address" => "required|nullable",
            "apartment" => "required|nullable",
            "floor" => "required|nullable",
            "landmark" => "sometimes|nullable",
            "email" => "sometimes|nullable|email",
            "primary" => "sometimes|nullable|boolean",
            "lat" => "required",
            "lng" => "required"
        ];

        $user = auth()->user();
        if ($user) {
            if ($user->type == User::TYPE_AFFILIATE) {
                $rules['phone'] = 'required|min:11|max:11';
            }
        } else {
            $rules['phone'] = 'required|min:11|max:11';
        }

        return $rules;
    }
}
