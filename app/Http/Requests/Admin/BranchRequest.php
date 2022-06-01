<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            "shop_name" => "required",
            "shop_name_ar" => "required",
            "address" => "required",
            "address_ar" => "required",
            "area" => "required",
            "area_ar" => "required",
            "lat" => "required",
            "lng" => "required",
            "direction_link" => "required",
            "phone" => "required|array",
            "email" => "nullable",
            "order" => "nullable",
            "type" => "required|in:".implode(',', array_keys(getBranchTypes())),
            "images" => "nullable",
        ];
    }
}
