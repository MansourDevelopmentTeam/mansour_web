<?php

namespace App\Models\Services;

use Illuminate\Support\Facades\Log;

class ValUPaymentService
{
	private $productList = [];

	private $storeId = "8666247";
	private $aggregatorId = "AGG1";
	private $userName = "VDR060319430";
	private $vendorName = "HarleyDavidson";

	public function __construct()
	{
		$this->client = new \GuzzleHttp\Client(["cookies" => true, 'defaults' => ['verify' => false]]);
	}

	public function getPlans($customer_mobile, $down_payment, $total_amount)
	{
		$data = [
	        "mobileNumber" => $customer_mobile,
	        "aggregatorId" => $this->aggregatorId,
	        "userName" => $this->userName,
	        "storeId" => $this->storeId,
	    ];

	    $this->productList[] = [
	        "productId" => "ETRPRPC23DP0",
	        "productPrice" => $total_amount,
	        "downPayment" => $down_payment,
	        "discount" => 0.00,
	        "expense" => 0.00,
	        "orderId" => "123"
	    ];

	    $data["productList"] = $this->productList;

	    $data["hmac"] = $this->generateHmac($data);

	    $res = $this->client->request("POST", "https://newcom1.valu.com.eg/api/enquiry", [
	    	\GuzzleHttp\RequestOptions::JSON => $data
	    ]);

	    $response = json_decode($res->getBody(), true);

	    return $response;
	}

	public function verifyCustomer($customer_mobile)
	{
		$data = [
	        "mobileNumber" => $customer_mobile,
	        "aggregatorId" => $this->aggregatorId,
	        "userName" => $this->userName,
	        "timeStamp" => (string)time(),
	        "storeId" => $this->storeId,
	        "orderId" => "123"
	    ];

	    $data["hmac"] = $this->generateHmac($data);

	    $res = $this->client->request("POST", "https://newcom1.valu.com.eg/api/verifyCustomer", [
	    	\GuzzleHttp\RequestOptions::JSON => $data
	    ]);

	    $response = json_decode($res->getBody(), true);

	    return $response;
	}

	public function purchase($customer_mobile, $order_id, $otp, $total_amount, $down_payment, $tenure)
	{
		$data = [
		    "mobileNumber" => $customer_mobile,
	        "aggregatorId" => $this->aggregatorId,
	        "userName" => $this->userName,
		    "storeId" => $this->storeId,
		    "otp" => $otp,
		    "vendorName" => $this->vendorName
		];

		$this->productList = [
		    [
		        "productId" => "ETRPRPC23DP0",
		        "productPrice" => $total_amount,
		        "orderId" => $order_id,
		        "discount" => 0.00,
		        "downPayment" => $down_payment,
		        "tenure" => $tenure,
		        "expense" => 0     
		    ]
		];

		$data["productList"] = $this->productList;
		$data["hmac"] = $this->generateHmac($data);
		Log::info($data);
	    $res = $this->client->request("POST", "https://newcom1.valu.com.eg/api/PurchaseProduct", [
	    	\GuzzleHttp\RequestOptions::JSON => $data
	    ]);

	    $response = json_decode($res->getBody(), true);

	    return $response;
	}

	public function generateHmac($data)
	{
		$productList = $data["productList"] ?? [];
		if (count($productList)) {
			foreach ($productList as $key => $value) {
			    uksort($productList[$key], function ($a, $b) {
			        if (strlen($a) == strlen($b)) {
			            return $a > $b;
			        }

			        return strlen($a) > strlen($b);
			    });
			}
		}

		$data["productList"] = $productList;

		uksort($data, function ($a, $b) {
		    if (strlen($a) == strlen($b)) {
		        return $a > $b;
		    }

		    return strlen($a) > strlen($b);
		});

		$string = "";
		foreach ($data as $key => $value) {
		    if (is_array($value)) {
		        foreach ($value as $key2 => $value2) {
		            foreach ($value2 as $key3 => $value3) {
		                $string .= $value3;
		            }
		        }
		    } else {
		        $string .= $value;
		    }
		}

		$hmac = hash_hmac('sha512', $string, "5PXYPGVRC8F8K9DLTGAJ7FWUDSP6Q4IL");

		return $hmac;
	}
}
