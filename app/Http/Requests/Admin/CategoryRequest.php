<?php

namespace App\Http\Requests\Admin;

use App\Rules\Admin\Slug;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
//            "name" => "required|string",
//            "slug" => ["required", new Slug('categories', $this->id)],
            "sub_categories" => "required|array",
//            "sub_categories.*.name" => "required|string",
//            "sub_categories.*.slug" => "required|string",
            "sub_categories.*.ex_rate_pts" => 'nullable|required_with:sub_categories.*.ex_rate_egp|integer',
            "sub_categories.*.ex_rate_egp" => 'nullable|required_with:sub_categories.*.ex_rate_pts|integer',
//            "sub_categories.*.payment_target" => 'sometimes|nullable|numeric'
        ];
    }

}
