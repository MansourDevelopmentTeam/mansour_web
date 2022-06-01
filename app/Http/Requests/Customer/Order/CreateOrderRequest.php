<?php

namespace App\Http\Requests\Customer\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrderRequest extends FormRequest
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
        $payment_ids = array_keys(config('payment.stores'));
        
        return [
            'payment_method' => [
                Rule::in($payment_ids)
            ],
            'use_wallet' => 'sometimes|nullable|boolean'
        ];
    }
}
