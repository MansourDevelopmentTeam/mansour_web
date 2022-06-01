<?php

namespace App\Http\Requests\Admin\Order;

use App\Rules\Admin\StockAvailable;
use Illuminate\Foundation\Http\FormRequest;

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
        return [
            "user_id" => "required|exists:users,id",
            "address_id" => "required|exists:addresses,id",
            "overwrite_fees" => "sometimes|nullable|boolean",
            "delivery_fees" => "sometimes|nullable|integer|min:0",
            "admin_notes" => "sometimes|nullable",
            'stock_available' => [new StockAvailable],
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'stock_available' => null,
        ]);
    }
}
