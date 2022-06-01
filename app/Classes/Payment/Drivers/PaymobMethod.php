<?php

namespace App\Classes\Payment\Drivers;

use Exception;
use Illuminate\Support\Arr;
use App\Models\Users\Address;
use App\Models\Products\Product;
use App\Models\Orders\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Payment\PaymentMethod;
use App\Classes\Shipping\ShippingConstant;
use Facades\App\Models\Repositories\CartRepository;
use App\Models\Repositories\TransactionRepository;
use App\Contracts\PaymentMethod AS PaymentMethodContracts;

/**
 * PaymobMethod class
 * @package App\Classes\Payment\Drivers\PaymobMethod
 */
class PaymobMethod extends Method implements PaymentMethodContracts
{
    const RESPONSE_SUCCESS = true;
    const RESPONSE_FAILURE = false;

    /**
     * PaymobMethod constructor.
     *
     * @param Array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
        $this->setResponseCode(202);
        $this->setCredentials($config['credentials']);
    }

    /**
     * Get redirect payement url
     *
     * @return void
     */
    public function getPaymentUrl()
    {
        $totalPayArr = $this->getTotalPay();

        $transaction = $this->transactionRepo->create($this->totalPay);

        $order_details = request()->all();
        $address = Address::find($order_details['address_id']);

        $orderCreation = $this->orderCreation($this->totalPay, $transaction, $address, $totalPayArr['items_price']);
        $payment_key = $this->PaymentKeyRequest($this->totalPay, $orderCreation['id'], $address);

        $transaction->update(['order_pay_id' => $orderCreation['id'], 'payment_transaction' => $orderCreation['id']]);

        if ($this->config['type'] == PaymentMethod::TYPE_CASH) {
            $this->setResponseCode(203);
            $pay_url = $this->getWalletUrl($payment_key, auth()->user()->phone ?? $address->phone);
        } else {
            $pay_url = $this->url . 'acceptance/iframes/' . $this->iframeID . '?payment_token=' . $payment_key;
        }

        return $pay_url;
    }

    /**
     * Complete payment
     *
     * @param Transaction $transaction
     * @return array
     */
    public function completePayment($transaction)
    {
        $orderData = $this->getOrderData(request()->id);

        Log::debug('responseCallBack - #OrderData: ' . json_encode($orderData));
        Log::debug('responseCallBack - #Request: ' . json_encode(request()->all()));

        $data = [
            'transaction_response' => request()->all(),
            'weaccept_transaction_id' => request()->id,
            'transaction_status' => request()->success === "true" ? Transaction::TRANSACTION_STATUS_SUCCESS : Transaction::TRANSACTION_STATUS_FAILURE,
            'card_info' => null,
        ];
        $transaction->update($data);

        $order_details = $transaction->order_details;
        $isSuccess = false;

        try {
            if ($transaction->transaction_status === Transaction::TRANSACTION_STATUS_SUCCESS) {
                if ($this->isInstallment()) {
                    $downPaymentInfo = $this->calculateInstallmentFees($orderData);
                    $order_details = array_merge($order_details, $downPaymentInfo);
                }

                $items = $this->setCustomer($transaction->customer)->getCartItems();

                $order_details['transaction_user_agent'] = $transaction->user_agent;
                $order_details['items'] = isset($transaction->order_details['items']) && count($transaction->order_details['items']) ? $transaction->order_details['items'] : $items;

                $isSuccess = true;
                $message = "Success";
            } else {
                $message = isset($transaction->transaction_response['data_message']) ? $transaction->transaction_response['data_message'] : "Transaction did not completed";
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        return [
            'success' => $isSuccess,
            'message' => $message,
            'data' => $isSuccess ? $order_details : []
        ];
    }
    /**
     * Verify if payment is success
     *
     * @param \App\Models\Orders\Transaction $transaction
     * @return boolean
     */
    public function verify(Transaction $transaction): bool
    {
        $response = $this->retrieveTransactionByOrder($transaction);

        if (isset($response['success'])) {
            $order_details = $transaction->order_details;

            if ($this->isInstallment()) {
                $downPaymentInfo = $this->calculateInstallmentFees($response);
                $order_details = array_merge($order_details, $downPaymentInfo);
            }

            $success = $response['success'] ? Transaction::TRANSACTION_STATUS_SUCCESS : Transaction::TRANSACTION_STATUS_FAILURE;
            $transaction->update(['transaction_status' => $success, 'transaction_response' => $response, 'order_details' => $order_details]);
            return $response['success'];
        }

        Log::error('We Accept method error ' . $this->getErrors($response ?? null));
        return false;
    }

    /**
     * Calculate the installment fees.
     *
     * @param [type] $orderDetials
     * @param [type] $paymentMethod
     * @return array
     */
    private function calculateInstallmentFees($orderDetials)
    {
        $result = [];

        $driver = $this->config['driver'];

        switch ($driver) {
            case "valu":
                $result['down_payment'] = data_get($orderDetials, 'data.down_payment') ?? 0;
                $result['admin_fees'] = 0; //$orderDetials->data->purchase_fees ?? 0; ##Change happened in valu response
                break;
            case "shahry":
                $result['down_payment'] = data_get($orderDetials, 'data.shahry_order.down_payment') ?? 0;
                $result['admin_fees'] = data_get($orderDetials, 'data.shahry_order.administrative_fees') ?? 0;
                break;
            case "souhoola":
                $result['down_payment'] = data_get($orderDetials, 'data.installment_info.downpaymentValue') ?? 0;
                $result['admin_fees'] = data_get($orderDetials, 'data.installment_info.adminFees') ?? 0;
                break;
            case "get_go":
                $result['down_payment'] = data_get($orderDetials, 'data.down_payment') ?? 0;
                $result['admin_fees'] = 0;
                break;
            default:
                $result['down_payment'] = 0;
                $result['admin_fees'] = 0;
                break;
        }
        return $result;
    }

    /**
     * Calculate the order grand total to aramex.
     *
     * @param Order $order
     * @return void
     */
    public function getAramexOrderTotal($order)
    {
        //TODO: Get aramex data from payment table
        $totalAmount = !is_null($order->invoice->discount) ? $order->invoice->discount : $order->invoice->total_amount;
        $deliveryFees = $order->invoice->delivery_fees;

        $driver = $this->config['driver'];

        switch ($driver) {
            case 'valu':
            case 'souhoola':
            case 'get_go':
            case 'shahry':
                $grandTotal = $totalAmount + $deliveryFees;
                $paymentService = ShippingConstant::SHIPPING_ARAMEX_PAYMENT_SERVICE;
                break;
            case 'visa_accept':
            case 'visa_accept_installment':
                $grandTotal = 0;
                $paymentService = '';
                break;
            case 'premium':
                $grandTotal = $deliveryFees;
                $paymentService = ShippingConstant::SHIPPING_ARAMEX_PAYMENT_SERVICE;

                break;
        }
        return [$grandTotal, $paymentService];
    }
    /**
     * Order Registration API
     *
     * @param [type] $totalAmount
     * @param \App\Models\Orders\Transaction $transaction
     * @param \App\Models\Users\Address $address
     * @param [type] $itemsPrice
     * @return object
     */
    private function orderCreation($totalAmount, $transaction, $address, $itemsPrice)
    {
        $host = $this->url . 'ecommerce/orders';

        $token = $this->Authentication();

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

            $response = Http::post($host, $postData);

            $result = $response->json();
            $this->logResponse($host, $result, $postData, 'order_creation');
            return $result;
        } catch (Exception $e) {
            throw new Exception("Order not created success in paymob #" . $e->getMessage());
        }
    }

    /**
     * Payment Key Request
     *
     * @param [type] $totalAmount
     * @param [type] $orderPayId
     * @param \App\Models\Users\Address $address
     * @return void
     */
    private function paymentKeyRequest($totalAmount, $orderPayId, $address)
    {
        $host = $this->url . 'acceptance/payment_keys';
        $token = $this->Authentication();

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
                "last_name" => auth()->user()->last_name || $address->customer_last_name ? (auth()->user()->last_name ?? $address->customer_last_name) : 'NA',
                "country" => "EG",
            ],
        ];

        try {
            $response = Http::post($host, $postData);
            $result = $response->json();

            $this->logResponse($host, $result, $postData, 'payment_key_request');
            return $result['token'];
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
    private function getWalletUrl($token, $phone)
    {
        $host = "{$this->url}acceptance/payments/pay";

        $postData = [
            "source" => [
                "identifier" => request('payment_method_phone') ?? $phone,
                "subtype" => "WALLET"
            ],
            "payment_token" => $token
        ];
        try {
            $response = Http::post($host, $postData);
            $result = $response->json();

            if ($result['redirect_url'] == "") {
                throw new Exception('Phone is not registered');
            }

            return $result['redirect_url'];
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Get order detials
     *
     * @param [type] $id
     * @return void|object
     */
    private function getOrderData($id)
    {
        $token = $this->Authentication();

        $host = $this->url . "acceptance/transactions/{$id}";

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
     * Retrieve transaction by order from paymob
     *
     * @param [type] $transaction
     * @return void
     */
    private function retrieveTransactionByOrder($transaction)
    {
        if ($transaction == null) {
            return [];
        }
        $token = $this->Authentication();

        $host = $this->url . 'ecommerce/orders/transaction_inquiry';

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
     * Authentication Request
     *
     * @return void
     */
    private function Authentication()
    {
        try {
            $response = Http::post("{$this->url}auth/tokens", [
                'api_key' => $this->authApiKey
            ]);

            $result = $response->json();
            return $result['token'];
        } catch (Exception $e) {
            return false;
        }
    }
    /**
     * Set credentials of paymob payment
     *
     * @return void
     */
    private function setCredentials($credentials)
    {
        $this->iframeID = $credentials['iframe_id'];
        $this->integrationID = $credentials['integration_id'];
        $this->authApiKey = $credentials['api_key'] ?? envFromDB('WE_ACCEPT_PAYMENT_API_KEY');
        $this->merchantID = $credentials['merchant_id'];
        $this->hmacHash = $credentials['hmac_hash'];
        $this->url = "https://accept.paymobsolutions.com/api/";
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
    }

    /**
     * Get errors
     *
     * @param int|null $code
     * @return void
     */
    private function getErrors($response): string
    {
        return $response['detail'] ?? "Invalid error";
    }
}
