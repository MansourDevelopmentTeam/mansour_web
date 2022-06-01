<?php

namespace App\Http\Requests;

use App\Models\Payment\Promotion\Promotion;
use App\Models\Payment\Promotion\PromotionConditions;
use App\Models\Payment\Promotion\PromotionTargets;
use Illuminate\Foundation\Http\FormRequest;

class PromotionRequest extends FormRequest
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
            "name" => "required",
            "name_ar" => "required",
            "start_date" => "required|date",
            "expiration_date" => "required|after:start_date",

            "active" => "required|in:0,1",

            "different_brands" => "in:0,1|nullable",
            "different_categories" => "in:0,1|nullable",
            "different_products" => "in:0,1,2|nullable",
            "override_discount" => "in:0,1|nullable",
            "check_all_conditions" => "in:0,1|nullable",

            "priority" => "required|integer|min:1",

            "exclusive" => "required|in:0,1",
            "periodic" => "nullable|integer|min:1",
            "group_id"  => "nullable",
            "times" => 'required_if:exclusive,1|nullable|integer',

            "type"    => 'required|integer|in:'.implode(',', Promotion::TYPES),
            "gift_ar" => "required_if:type,".Promotion::TYPES['gift'].",".Promotion::TYPES['both'],
            "gift_en" => "required_if:type,".Promotion::TYPES['gift'].','.Promotion::TYPES['both'],

            "discount_qty" => "nullable",

            "conditions" => ['required_unless:type,'.Promotion::TYPES['direct_discount'],'array'], // not required in type direct discount
            "conditions.*.item_type" => ['required', 'in:' . implode(',', PromotionConditions::ITEM_TYPES)],
            "conditions.*.item_id" => ['nullable',
                function ($attribute, $value, $fail)  {

                    $index = explode('.', $attribute)[1];

                    $type = $this->request->get('conditions')[$index]['item_type'];

                    if ($type == PromotionConditions::ITEM_TYPES['lists'] && !\DB::table('lists')->where('id', $value)->exists()) {
                        $fail('The ' . $attribute . ' is invalid.');
                    }

                }, 'required_if:conditions.*.item_type,1'],
            "conditions.*.custom_list"   => ['required_if:conditions.*.item_type,2', 'array'],
            "conditions.*.custom_list.*" => ['exists:products,id'],
            "conditions.*.amount"        => 'required_without:conditions.*.quantity',
            "conditions.*.quantity"      => 'required_without:conditions.*.amount',
            "conditions.*.operator"      => 'required|in:0,1',
            "targets"             => ['array'],
            "targets.*.item_type" => ['required','in:'.PromotionTargets::ITEM_TYPES['products']], // just products with quantity
            "targets.*.item_id"   => ['required', 'exists:products,id'],
            "targets.*.quantity"  => ['required', "numeric"],
            "targets.*.operator"  => 'required|in:0,1',
            "discount" => "required_with:targets",
            'instant'             => 'sometimes|nullable|boolean',
            'incentive_id' => 'required|integer',
            'description' => 'sometimes|nullable|string',
            'description_ar' => 'sometimes|nullable|string'
        ];
    }
}
