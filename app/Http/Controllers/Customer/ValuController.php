<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Services\ValUPaymentService;
use App\Models\Users\User;
use Illuminate\Http\Request;

class ValuController extends Controller
{
	private $valuService;

	public function __construct(ValUPaymentService $valuService)
	{
		$this->valuService = $valuService;
	}

    
    public function getPlans(Request $request)
    {
    	$this->validate($request, [
    		"mobile_number" => "required",
    		"down_payment" => "required",
    		"total_amount" => "required"
    	]);

    	$response = $this->valuService->getPlans($request->mobile_number, $request->down_payment, $request->total_amount);
        
        if ($response["responseCode"] == "0") {
        	return $this->jsonResponse("Success", $response);
        } else {
            return $this->errorResponse($response["responseDesc"], "Invalid data", [], 422);
        }
    }

    public function verifyCustomer(Request $request)
    {
    	$this->validate($request, [
            "mobile_number" => "required",
        ]);

        $response = $this->valuService->verifyCustomer($request->mobile_number);

        return $this->jsonResponse('Success');
    }
}
