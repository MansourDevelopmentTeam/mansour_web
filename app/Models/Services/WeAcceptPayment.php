<?php

namespace App\Models\Services;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use App\Models\Users\Address;
use App\Models\Products\Product;
use App\Models\Orders\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Payment\PaymentMethod;
use App\Models\Payment\PaymentMethods;
use App\Exceptions\TransactionException;
use Facades\App\Models\Services\OrdersService;
use App\Exceptions\TransactionNotFoundException;
use App\Models\Repositories\TransactionRepository;
use Facades\App\Models\Repositories\CartRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * WeAccept Payment Service
 * @deprecated v1.0
 */
class WeAcceptPayment
{
    private $authApiKey;
    private $merchantID;
    private $integrationID;
    private $iframeID;
    private $hmacHash;

    private $client;
    protected $transactionRepo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
        $this->transactionRepo = new TransactionRepository;
        $this->authApiKey = config('payment.we_accept_credential.api_key');
    }

    /**
     * Get url iframe pay
     *
     * @param [type] $totalAmount
     * @param [type] $orderData
     * @param \App\Models\Users\Address $address
     * @param [type] $itemsPrice
     * @return array
     */
    public function Pay($totalAmount, $orderData, $address, $itemsPrice = null): array
    {
        $this->setCredentials($orderData['payment_method']);

        $token = $this->Authentication();
        if (!$token) {
            throw new Exception('Token not created in paymob');
        }
        // @deprecated V1.0
        // $transaction = $this->CreateTransaction($totalAmount, null, $orderData);

        $transaction = $this->transactionRepo->create($totalAmount);

        if (!$transaction) {
            $orderData['customer_id'] = auth()->user()->id;
            throw new TransactionException('Transaction not created with paymob #' . json_encode($orderData));
        }

        $orderCreation = $this->OrderCreation($token, $totalAmount, $transaction, $address, $itemsPrice);

        $transaction->update(['order_pay_id' => $orderCreation->id, 'payment_transaction' => $orderCreation->id]);

        $payment_key = $this->PaymentKeyRequest($token, $totalAmount, $orderCreation->id, $address, $transaction);

        return [$this->iframeID, $payment_key];
    }
        /**
     * Order Registration API
     *
     * @param [type] $token
     * @param [type] $totalAmount
     * @param \App\Models\Orders\Transaction $transaction
     * @param \App\Models\Users\Address $address
     * @param [type] $itemsPrice
     * @return object
     */
    public function OrderCreation($token, $totalAmount, $transaction, $address, $itemsPrice)
    {
        $host = 'https://accept.paymobsolutions.com/api/ecommerce/orders';

        $postData = [
            'auth_token' => $token,
            'delivery_needed' => false,
            'merchant_order_id' => $transaction->id . "-" . rand(10000, 99999),
            'merchant_id' => $this->merchantID,
            'amount_cents' => (int)$totalAmount,
            'currency' => "EGP",
            'items' => []
        ];
        if ($address && $address->customer_first_name && $address->customer_last_name) {
            $postData = Arr::add($postData, 'shipping_data.first_name', auth()->user()->name ?? $address->customer_first_name);
            $postData = Arr::add($postData, 'shipping_data.last_name', auth()->user()->last_name ?? $address->customer_last_name);
            $postData = Arr::add($postData, 'shipping_data.phone_number', auth()->user()->phone ?? $address->phone);
            $postData = Arr::add($postData, 'shipping_data.email', auth()->user()->email ?? $address->email);
        }

        try {
            $items = CartRepository::getUserCartItems();
            foreach ($items as $item) {
                $product = Product::find($item['id']);
                $postData['items'][] = [
                    "name" => $product->name,
                    "description" => strip_tags($product->description),
                    "amount_cents" => $itemsPrice[$product->id] * 100,
                    "quantity" => $item['amount']
                ];
            }

            $postData['host'] = $host;
            $postData['iframe_id'] = $this->iframeID;
            $postData['integration_id'] = $this->integrationID;
            $postData['api_key'] = $this->authApiKey;
            $postData['merchant_id'] = $this->merchantID;
            $postData['hmac_hash'] = $this->hmacHash;

            $transaction->update([
                "transaction_request" => $postData
            ]);

            $apiRequest = $this->client->post(
                $host,
                ['body' => json_encode($postData)]
            );
            $response = json_decode($apiRequest->getBody());

            $this->logResponse($host, $response, $postData, 'order_creation');
            return $response;
        } catch (Exception $e) {
            throw new Exception("Order not created success in paymob #" . $e->getMessage());
        }
    }

    /**
     * Payment Key Request
     *
     * @param [type] $token
     * @param [type] $totalAmount
     * @param [type] $orderPayId
     * @param \App\Models\Users\Address $address
     * @return void
     */
    private function PaymentKeyRequest($token, $totalAmount, $orderPayId, $address)
    {
        $host = 'https://accept.paymobsolutions.com/api/acceptance/payment_keys';

        $postData = [
            'auth_token' => $token,
            'amount_cents' => (int)$totalAmount,
            'expiration' => 3600,
            'order_id' => $orderPayId,
            'currency' => "EGP",
            'integration_id' => $this->integrationID,
            'billing_data' => [
                "apartment" => $address->apartment ?? "NA",
                "email" => auth()->user()->email ?? $address->email,
                "floor" => $address->floor ?? "NA",
                "first_name" => auth()->user()->name ??  $address->customer_first_name,
                "phone_number" => auth()->user()->phone ?? $address->phone,
                "city" => $address->city->name ?? "NA",
                "state" => $address->area->name ?? "NA",
                "street" => $address->address ?? "NA",
                "building" => $address->address ?? "NA",
                "last_name" => auth()->user()->last_name ?? $address->customer_last_name,
                "country" => "EG",
            ],
        ];

        try {
            $apiRequest = $this->client->post(
                $host,
                ['body' => json_encode($postData)]
            );
            $response = json_decode($apiRequest->getBody());
            $this->logResponse($host, $response, $postData, 'payment_key_request');
            return $response->token;
        } catch (Exception $e) {
            $this->logResponse($host, [], $postData, 'payment_key_request_fail');

            throw new Exception("Payment key request not created success in paymob #" . $e->getMessage());
        }
    }

    /**
     * Get wallet url for mobile payment 
     *
     * @param [type] $token
     * @param [type] $phone
     * @throws Exception
     * @return string
     */
    public function getWalletUrl($token, $phone)
    {
        $host = "{$this->url}/acceptance/payments/pay";
        $client = new Client();

        $options = [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                "source" => [
                    "identifier" => request('payment_method_phone') ?? $phone,
                    "subtype" => "WALLET"
                ],
                "payment_token" => $token
            ]
        ];
        try {
            $apiRequest = $client->post($host, $options);
            $response = json_decode($apiRequest->getBody());

            if($response->redirect_url == ""){
                throw new Exception('Phone is not registered');
            }

            return $response->redirect_url;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function processesCallback($request)
    {
        $hmac = $this->calculateHMAC($request->all());

        if ($hmac != $request->hmac) {
            //return false;
        }

        $orderId = Arr::get($request->get('obj'), 'order.id');
        $transaction_status = Arr::get($request->get('obj'), 'success');

        $transaction = Transaction::where('order_pay_id', $orderId)->first();
        if (!$transaction) {
            // return redirect(config('app.url') . '/online_order?is_success=false&message=transaction not found')->send();
            throw new TransactionNotFoundException('Transaction not found');
        }
        $data = [
            'transaction_processe' => $request->all(),
            'transaction_status' => $transaction_status == true ? Transaction::TRANSACTION_STATUS_SUCCESS : Transaction::TRANSACTION_STATUS_FAILURE,
            'card_info' => null,
        ];
        $transaction->update($data);
        Log::channel("we_accept")->info("pay_callback \n" . json_encode(['request' => $request->all(), 'transaction' => $transaction]));
        return $transaction;
    }

    public function responseCallBack($request)
    {
        $hmac = $this->calculateHMAC($request->all());

        if ($hmac != $request->hmac) {
            //return false;
        }

        $orderId = $request->order;

        $transaction = Transaction::where('order_pay_id', $orderId)->first();
        if (!$transaction) {
            // return redirect(config('app.url') . '/online_order?is_success=false&message=transaction not found')->send();
            throw new TransactionNotFoundException('Transaction not found');
        }
        $data = [
            'transaction_response' => $request->all(),
            'weaccept_transaction_id' => $request->id,
            'transaction_status' => $request->success == true ? Transaction::TRANSACTION_STATUS_SUCCESS : Transaction::TRANSACTION_STATUS_FAILURE,
            'card_info' => null,
        ];

        $transaction->update($data);
        Log::channel("we_accept")->info("pay_callback \n" . json_encode(['request' => $request->all(), 'transaction' => $transaction]));
        return $transaction;
    }



    /**
     * Authentication Request
     *
     * @return void
     */
    private function Authentication()
    {
        $host = 'https://accept.paymobsolutions.com/api/auth/tokens';

        $postData = ['api_key' => $this->authApiKey];
        try {
            $apiRequest = $this->client->post(
                $host,
                ['body' => json_encode($postData)]
            );
            $response = json_decode($apiRequest->getBody());
            return $response->token;
        } catch (HttpException $ex) {
            return false;
        }
    }

    /**
     * Get order detials
     *
     * @param [type] $id
     * @return void|object
     */
    public function getOrderData($id)
    {
        $token = $this->Authentication();

        $host = "https://accept.paymobsolutions.com/api/acceptance/transactions/{$id}";

        try {
            $response = Http::withHeaders([
                'authorization' => $token
            ])->get($host);

            $result = $response->json();

            $this->logResponse($host, $result, [], 'retrieve_transaction');
            return $result;
        } catch (\Exception $e) {
            Log::error("Weaccept method retrieveTransaction error . " . $e->getMessage());
        }
        return [];
    }

    /**
     * HMAC Calculation
     *
     * @param [type] $requestData
     * @return string
     */
    private function calculateHMAC($requestData)
    {
        $requestData = isset($requestData['obj']) ? $requestData['obj'] : $requestData;

        $hmacKeys = [
            "amount_cents",
            "created_at",
            "currency",
            "error_occured",
            "has_parent_transaction",
            "id",
            "integration_id",
            "is_3d_secure",
            "is_auth",
            "is_capture",
            "is_refunded",
            "is_standalone_payment",
            "is_voided",
            "order.id",
            "owner",
            "pending",
            "source_data.pan",
            "source_data.sub_type",
            "source_data.type",
            "success"
        ];

        $requestValues = [];
        foreach ($hmacKeys as $key) {
            $value = Arr::get($requestData, $key);
            if ($value === true) {
                $value = "true";
            } elseif ($value === false) {
                $value = "false";
            }
            $requestValues[] = $value;
        }

        $sig = hash_hmac('sha512', implode('', $requestValues), $this->hmacHash);

        return $sig;
    }

    /**
     * log operations
     *
     * @param $url
     * @param $finalOutput
     * @param $options
     * @param string $type
     */
    private function logResponse($url, $finalOutput, $options, $type = 'page')
    {
        Log::debug("{$type} \n" .
            json_encode([
                'requestData' => request()->all(),
                'http' => [
                    'url' => $url,
                    'response' => $finalOutput,
                    'request' => $options,
                ],
        ]));

        Log::channel("we_accept")->info(
            "{$type} \n" .
            json_encode([
                'requestData' => request()->all(),
                'http' => [
                    'url' => $url,
                    'response' => $finalOutput,
                    'request' => $options,
                ],
            ])
        );
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
    private function CreateTransaction($totalAmount, $orderPayId, $orderData)
    {
        // DEPRECATED
        $items = CartRepository::getUserCartItems();
        $orderData['items'] = $items->toArray();
        $orderData['user_ip'] = getRealIp();

        $data = [
            'order_details' => $orderData,
            'payment_method_id' => $orderData['payment_method'],
            'order_pay_id' => $orderPayId,
            'total_amount' => $totalAmount,
            'customer_id' => auth()->user()->id,
            'user_agent' => OrdersService::getUSerAgent(isset($orderData['device_type']) ? $orderData['device_type'] : null)
        ];
        return Transaction::create($data);
    }

    public function retrieveTransaction($transaction)
    {
        if ($transaction == null || $transaction->weaccept_transaction_id) {
            return [];
        }
        $this->setCredentials($transaction->payment_method_id);
        $token = $this->Authentication();

        $host = 'https://accept.paymob.com/api/acceptance/transactions/' . $transaction->weaccept_transaction_id;
        try {
            $response = Http::withHeaders([
                'authorization' => $token
            ])->get($host);

            $result = $response->json();

            $this->logResponse($host, $result, [], 'retrieve_transaction');
            return $result;
        } catch (\Exception $e) {
            Log::error("Weaccept method retrieveTransaction error . " . $e->getMessage());
        }
        return [];
    }

    public function retrieveTransactionByOrder($transaction)
    {
        if ($transaction == null) {
            return [];
        }
        $this->setCredentials($transaction->payment_method_id);
        $token = $this->Authentication();

        $host = 'https://accept.paymobsolutions.com/api/ecommerce/orders/transaction_inquiry';
        try {
            $requestBody = [
                "auth_token" => $token,
                "order_id" => $transaction->order_pay_id
            ];
            $response = Http::post($host, $requestBody);
            $result = $response->json();

            $this->logResponse($host, $result, [], 'retrieve_transaction');
            return $result;
        } catch (\Exception $e) {
            Log::error("Weaccept method retrieveTransaction error . " . $e->getMessage());
        }
        return [];
    }

    /**
     * Set credentials of we accept payment
     *
     * @param int $method_id
     * @param int $plan_id
     * @return void
     */
    private function setCredentials($method_id)
    {
        $credentials = config("payment.stores.{$method_id}.credentials");

        $this->iframeID = $credentials['iframe_id'];
        $this->integrationID = $credentials['integration_id'];
        $this->authApiKey = $credentials['api_key'] ?? envFromDB('WE_ACCEPT_PAYMENT_API_KEY');
        $this->merchantID = $credentials['merchant_id'];
        $this->hmacHash = $credentials['hmac_hash'];
        $this->url = "https://accept.paymobsolutions.com/api";
    }
}
