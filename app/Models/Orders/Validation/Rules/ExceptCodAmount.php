<?php

namespace App\Models\Orders\Validation\Rules;


use Facades\App\Models\Services\OrdersService;
use App\Models\Orders\Validation\ValidationError;

class ExceptCodAmount implements RulesInterface
{
	public $name = "schedule_date";
	private $order_data;
	private $user;

	public function __construct($order_data, $user)
	{
		$this->order_data = $order_data;
		$this->user = $user;
	}

    public function validate()
    {
        $request = request();
        
        $totalAmount = OrdersService::getTotalAmount($request->all());
        if (!is_null(config('constants.except_cod_amount')) && ($totalAmount / 100) >= config('constants.except_cod_amount') && $request->payment_method == 1) {
            // return new ValidationError("Cash method allowed for orders with total lower than {config('constants.except_cod_amount')}", 423);
            return new ValidationError("Select another payment method because you have exceeded the max {config('constants.except_cod_amount')}. use of cash on delivery", 423);
        }
    }
}
