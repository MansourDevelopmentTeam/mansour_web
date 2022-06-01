<?php

namespace App\Models\Services;

use Exception;
use GuzzleHttp\Client;
use App\Models\Orders\Order;
use App\Models\Orders\Transaction;
use App\Models\Payment\Qnb\Parser;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Payment\Qnb\api_lib;
use Illuminate\Support\Facades\Log;
use App\Models\Payment\Qnb\Merchant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Payment\PaymentInstallment;
use Facades\App\Models\Repositories\CartRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class BankPayment
{
    private $gatewayUrl;
    private $merchantId;
    private $apiUsername;
    private $password;
    private $ordersService;

    public function __construct(OrdersService $ordersService)
    {
        $this->ordersService = $ordersService;
    }

    /**
     * create transaction with bank payment
     *
     * @deprecated v1.0
     * @param [type] $totalAmount
     * @param [type] $orderData
     * @return void
     */
    public function Pay($totalAmount, $orderData)
    {
        //DEPRECATED
        $this->setCredentials($orderData['payment_method'], $orderData['plan_id']);

        $transaction = $this->CreateTransaction($totalAmount, null, $orderData);
        if (!$transaction) {
            return false;
        }
        $payOrder = $this->payOrder($transaction);

        return $payOrder;
    }

    /**
     * Payment view 
     *
     * @api api/customer/orders/payment-view/{$transactionId} GET
     * 
     * @param [type] $transaction
     * @return void
     */
    public function payOrder($transaction)
    {
        $user = auth()->user();

        if($user){
            $token = JWTAuth::fromUser($user);
            $user_id = $user->id;
        }else{
            $token = null;
            $user_id = null;
        }

        $transaction = Transaction::where('id', $transaction->id)->where('customer_id', $user_id)->firstOrFail();

        $this->setCredentials($transaction->order_details['payment_method'], $transaction->order_details['plan_id']);

        //Creates the Merchant Object from config. If you are using multiple merchant ID's,
        // you can pass in another configArray each time, instead of using the one from Merchant.php
        $configArray = array();
        $configArray["certificateVerifyPeer"] = FALSE;
        $configArray["certificateVerifyHost"] = 0;
        $configArray["gatewayUrl"] = $this->gatewayUrl;
        $configArray["merchantId"] = $this->merchantId;
        $configArray["apiUsername"] = $this->apiUsername;
        $configArray["password"] = $this->password;
        $configArray["debug"] = TRUE;
        $configArray["version"] = "49";

        //Form the array to obtain the checkout session ID.
        $request_assoc_array = [
            "apiOperation" => "CREATE_CHECKOUT_SESSION",
            "order.id" => $transaction->id,
            "order.amount" => $transaction->total_amount / 100,
            "order.currency" => "EGP"
        ];

        $this->logSendRequest($transaction, $request_assoc_array, $configArray);


        $merchantObj = new Merchant($configArray);
        
        // The Parser object is used to process the response from the gateway and handle the connections
        // and uses connection.php
        $parserObj = new Parser($merchantObj);
        
        //The Gateway URL can be set by using the following function, or the
        //value can be set in Merchant.php
        //$merchantObj->SetGatewayUrl("https://secure.uat.tnspayments.com/api/nvp");
        $requestUrl = $parserObj->FormRequestUrl($merchantObj);
        
        //This is a library if useful functions
        $new_api_lib = new api_lib;
        
        //Use a method to create a unique Order ID. Store this for later use in the receipt page or receipt function.
        $order_id = $new_api_lib->getRandomString(10);
        
        //This builds the request adding in the merchant name, api user and password.
        $rqst = $parserObj->ParseRequest($merchantObj, $request_assoc_array);
        //Submit the transaction request to the payment server
        $response = $parserObj->SendTransaction($merchantObj, $rqst);
        
        //Parse the response
        $parsed_array = $new_api_lib->parse_from_nvp($response);
        
        if(isset($parsed_array['error.explanation'])){

            $transaction->update([
                'transaction_processe' => json_encode($parsed_array),
                'transaction_status' => Transaction::TRANSACTION_STATUS_FAILURE,
            ]);
            throw new Exception("BANK INSTALLMENT ERROR " . $parsed_array['error.explanation']);
        }

        //Store the successIndicator for later use in the receipt page or receipt function.
        $successIndicator = $parsed_array['successIndicator'];

        //The session ID is passed to the Checkout.configure() function below.
        $session_id = $parsed_array['session.id'];

        $transaction->update([
            'session'=>$session_id,
            "payment_transaction" => $transaction->id,
            'success_indicator'=>$successIndicator,
            'transaction_processe' => json_encode($parsed_array),
            'transaction_status' => Transaction::TRANSACTION_STATUS_SUCCESS,
        ]);
        $merchantID = $merchantObj->GetMerchantId();

        return view("payment.checkout", [
            "merchantId" => $merchantID, 
            "checkoutJs" => $this->checkoutJs,
            "transaction" => $transaction, 
            "customerId" => $transaction->customer_id, 
            "order_currency" => "EGP", 
            "session_id" => $session_id, 
            "token" => $token
        ]);
    }

    public function payCallBack($transaction,$request)
    {
        $user = auth()->user();
        $resultIndicator = $request->resultIndicator;
        if ($resultIndicator == $transaction->success_indicator) {
            $transaction->update(['transaction_response' => $request->all(), 'transaction_status' => Transaction::TRANSACTION_STATUS_SUCCESS]);
            $order = Order::where('transaction_id', $transaction->id)->first();
            if (!$order) {
                $order = $this->ordersService->createOrder($transaction->order_details, $transaction->id, $user);

                $url = config('app.website_url') . "/checkout/final-receipt/{$order->id}?is_success=true";
            }
        } else {
            $transaction->update(['transaction_response' => $request->all(), Transaction::TRANSACTION_STATUS_FAILURE]);

            $url = config('app.website_url') . "/checkout/final-receipt?is_success=false&message=Transaction did not completed";
        }
        return $url;
    }
    /**
     * Create tranaction
     *
     * @deprecated v1.0
     * @param  int $totalAmount
     * @param  int $orderPayId
     * @param  array $orderData
     * @return Transaction
     */
    public function CreateTransaction($totalAmount, $orderData)
    {
        // DEPRECATED
        $items = CartRepository::getUserCartItems();
        $orderData['items'] = $items->toArray();
        $orderData['user_ip'] = getRealIp();

        $orderData['plan_id'] = isset($orderData['plan_id']) ? $orderData['plan_id'] : null;

        $data = [
            'order_details' => $orderData,
            'payment_method_id' => $orderData['payment_method'],
            // 'order_pay_id' => null,
            'total_amount' => $totalAmount,
            'customer_id' => auth()->user()->id,
        ];
        $transaction = Transaction::create($data);
        return $transaction;
    }
    public function retrieveOrder($transaction)
    {
        if($transaction == null){
            return [];
        }

        $this->setCredentials($transaction->payment_method_id, $transaction->order_details['plan_id']);

        try {
            $response = Http::withBasicAuth($this->apiUsername, $this->password)
                    ->get("{$this->baseUrl}/merchant/{$this->merchantId}/order/{$transaction->id}");

            return $response->json();

        }catch (\Exception $e) {
            Log::error("MasterCard method retrieveOrder error . " . $e->getMessage());
        }
        return [];
    }

    /**
     * Set credentials of bank payment
     *
     * @param int $method_id
     * @param int $plan_id
     * @return void
     */
    private function setCredentials($method_id, $plan_id)
    {
        $paymentObj = config("payment.stores.{$method_id}");
        $credentials = $paymentObj['credentials'];

        if($paymentObj['isInstallment']){
            $plan = Cache::remember("payment.plan.{$plan_id}", 60 * 30, function () use($plan_id) {
                return PaymentInstallment::find($plan_id);
            });

            if($plan == null){
                throw new Exception("Plan not found");
            }

            $username = $plan->username;
            $merchant_id = $plan->merchant_id;
            $password = $plan->password;
        }else{
            $username = $credentials['username'];   
            $merchant_id = $credentials['merchant_id'];
            $password = $credentials['password'];
        }

        $this->baseUrl = $credentials['base_url'];
        $this->gatewayUrl = $credentials['gateway_url'];
        $this->checkoutJs = $credentials['checkout_js'];
        $this->apiUsername = $username;
        $this->merchantId = $merchant_id;
        $this->password = $password;
    }

    /**
     * Logging sending request
     *
     * @param Transaction $transaction
     * @param array $request_assoc_array
     * @param array $configArray
     * @return void
     */
    private function logSendRequest($transaction, $request_assoc_array, $configArray)
    {
        $request = array_merge($request_assoc_array, $configArray);
        
        if(isset($request['password']) && $request['password'] != ""){
            $request['password'] = password_hash($request['password'], PASSWORD_DEFAULT);
        }else {
            $request['password'] = null;
        }

        $transaction->update([
            "transaction_request" => json_encode($request)
        ]);
    }
}
