<?php

namespace App\Models\Orders\Validation\Rules;

use App\Models\Payment\PaymentMethod;
use Illuminate\Support\Facades\Cache;
use App\Models\Orders\Validation\ValidationError;

/**
 * Payment type Rule Class
 * @package App\Models\Orders\Validation\Rules\PaymentType
 */
class PaymentType implements RulesInterface
{
    /** @var string $RuleName */
	public $name = "payment_type";
	public $lang;

	public function __construct($lang = 1)
	{
        $this->lang = $lang;
	}
    /**
     * Validate order
     *
     * @return void
     * @throws ValidationError
     */
    public function validate()
    {
        $id = request()->get('payment_method');
        $payment_method = Cache::remember("payment.{$id}", 60 * 30, function () use ($id) {
            return PaymentMethod::find($id);
        });

        if ($payment_method && $payment_method->type == PaymentMethod::TYPE_INSTALLMENT && !request()->has('plan_id') && request()->get('plan_id') == null) {
            return new ValidationError(trans('mobile.plan_id_required'), 423);
        }
    }
}
