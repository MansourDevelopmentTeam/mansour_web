<?php

namespace App\Http\Requests;

use App\Models\Payment\Promotion\Promotion;
use App\Models\Payment\Promotion\PromotionB2B_Segments;
use App\Models\Payment\Promotion\PromotionConditions;
use App\Models\Payment\Promotion\PromotionTargets;
use Illuminate\Foundation\Http\FormRequest;

class PromotionB2BRequest extends FormRequest
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
            "name"              => "required",
            "name_ar"           => "required",
            "start_date"        => "required|date",
            "expiration_date"   => "required|after:start_date",
            "active"            => "required|in:0,1",
            "priority"          => "required|integer",
//            "times"             => 'nullable|integer',
            "periodic" => "nullable|integer|min:1",

            "conditions"                 => ['required','array'],
            "conditions.*.item_type"     => ['required', 'in:1'],
            "conditions.*.item_id"       => ['required', function ($attribute, $value, $fail)  {
                    $index = explode('.', $attribute)[1];
                    $type = $this->request->get('conditions')[$index]['item_type'];
                    if ($type == PromotionConditions::ITEM_TYPES['lists'] && !\DB::table('lists')->where('id', $value)->exists()) {
                        $fail('The ' . $attribute . ' is invalid.');
                    }
                }],
            "conditions.*.amount"        => 'nullable',
            "conditions.*.quantity"      => 'nullable',

            "segments"                     => ['required', 'array'],
            "segments.*.min"               => ['required'],
            "segments.*.max"               => ['nullable'],
            "segments.*.override_range"    => ['required', 'in:0,1'],
            "segments.*.discount_type"     => ['required', 'in:'.implode(',', PromotionB2B_Segments::DISCOUNT_TYPES)],
            "segments.*.discount"          => ['required'],
            "segments.*.iterator"          => ['required_if:segments.*.discount_type,'.PromotionB2B_Segments::DISCOUNT_TYPES['ValuePerItem']],
            'instant'                      => 'sometimes|nullable|boolean',
            'incentive_id' => 'required|integer',
            'description' => 'sometimes|nullable|string',
            'description_ar' => 'sometimes|nullable|string'
        ];
    }
}
