<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use App\Models\Payment\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class PaymentMethodRequest extends FormRequest
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
            'name' => 'required|string',
            'name_ar' => 'required|string',
            'provider' => ['required', Rule::in(array_keys(config('payment.providers')))],
            'icon' => 'required|string',
            'is_installment' => 'sometimes|boolean',
            'active' => 'sometimes|boolean',
        ];
        if(!$this->is_installment){
            $rules['credentials.api_key'] = 'required_if:provider,' . PaymentMethod::PROVIDER_WEACCEPT;
            $rules['credentials.iframe_id'] = 'required_if:provider,' . PaymentMethod::PROVIDER_WEACCEPT;
            $rules['credentials.integration_id'] = 'required_if:provider,' . PaymentMethod::PROVIDER_WEACCEPT;            
            
            $rules['credentials.username'] = 'required_if:provider,' . PaymentMethod::PROVIDER_BANK;
            $rules['credentials.password'] = 'required_if:provider,' . PaymentMethod::PROVIDER_BANK;

            $rules['credentials.server_key'] = 'required_if:provider,' . PaymentMethod::PROVIDER_PAYTABS;
            $rules['credentials.profile_id'] = 'required_if:provider,' . PaymentMethod::PROVIDER_PAYTABS;
 
            $rules['credentials.merchant_id'] = 'required_if:provider,' . PaymentMethod::PROVIDER_BANK . ',' . PaymentMethod::PROVIDER_WEACCEPT;
        }
        return $rules;
    }
}
