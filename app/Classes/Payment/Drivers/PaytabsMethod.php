<?php

namespace App\Classes\Payment\Drivers;

use Exception;
use Carbon\Carbon;
use App\Classes\Shipping\ShippingConstant;
use App\Models\Users\Address;
use App\Contracts\PaymentMethod;
use App\Jobs\CheckPayTapsPayment;
use App\Models\Orders\Transaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\Repositories\TransactionRepository;

class PaytabsMethod extends Method implements PaymentMethod
{
    const RESPONSE_SUCCESS = "A";
    protected $credentials;

    /**
     * PaytabsMethod constructor.
     *
     * @param Array $config
     */
    public function __construct(array $config)
    {
        $this->credentials = $config['credentials'];
        parent::__construct($config);
        $this->setResponseCode(203);
    }

    /**
     * Get redirect payement url
     *
     * @return void
     */
    public function getPaymentUrl()
    {
        $totalPayArr = $this->getTotalPay();

        $transaction = $this->transactionRepo->create($totalPayArr['grand_total']);

        $requestBody = $this->handleRequest($transaction);

        $response = Http::withHeaders([
            'authorization' => $this->credentials['server_key']
        ])->post($this->credentials['baseUrl'] . 'payment/request', $requestBody);

        $payment_reference = null;
        $rediretUrl = null;
        $requestBody['server_key'] = $this->credentials['server_key'];
        if ($response->ok()) {
            $result = $response->json();
            $payment_reference = $result['tran_ref'];
            $rediretUrl = $result['redirect_url'];

            CheckPayTapsPayment::dispatch($transaction, request()->all())->delay(Carbon::now()->addMinutes(10));
            CheckPayTapsPayment::dispatch($transaction, request()->all())->delay(Carbon::now()->addMinutes(40));
        }

        $transaction->update([
            "payment_transaction" => $payment_reference,
            "payment_reference" => $payment_reference,
            "transaction_request" => $requestBody,
        ]);
        return $rediretUrl;
    }
    /**
     * Complete payment
     *
     * @param Transaction $transaction
     * @return void
     */
    public function completePayment($transaction)
    {
        $response_status = request()->input('payment_result.response_status') ?? request()->input('respStatus');
        $transaction->update([
            "transaction_response" => json_encode(request()->all()),
            "transaction_status" => in_array($response_status, ["A"]) ? Transaction::TRANSACTION_STATUS_SUCCESS : Transaction::TRANSACTION_STATUS_FAILURE,
        ]);

        $order_details = $transaction->order_details;
        $isSuccess = false;

        try {
            if ($transaction->transaction_status === Transaction::TRANSACTION_STATUS_SUCCESS) {

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
        $requestBody = [
            "profile_id" => $this->credentials['profile_id'],
            "tran_ref" => $transaction->payment_transaction,
        ];
        try {

            $response = Http::withHeaders([
                'authorization' => $this->credentials['server_key']
            ])->post($this->credentials['baseUrl'] . 'payment/query', $requestBody);

            $result = $response->json();

            if ($response->ok() && $response) {
                $success = data_get($result, 'payment_result.response_status') == self::RESPONSE_SUCCESS;
                $transaction->update(['transaction_response' => $response, 'transaction_status' => $success ? Transaction::TRANSACTION_STATUS_SUCCESS : Transaction::TRANSACTION_STATUS_FAILURE]);

                return $success;
            }
            Log::error('Paytabs method error ' . $this->getErrors($result['code'] ?? null));
        } catch (\Exception $e) {
            Log::error('Paytabs method error ' . $e->getMessage());
        }

        return false;
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
        $grandTotal = 0;
        $payment_services = '';
        
        return [$grandTotal, $payment_services];
    }

    /**
     * Handle payment body request
     *
     * @api /payment/request
     * @param Transaction $transaction
     * @return array
     */
    private function handleRequest(Transaction $transaction)
    {
        $user_id = $transaction->customer_id;
        $address_id = $transaction->order_details['address_id'];
        $address = Address::with('city')->where('user_id', $user_id)->where('id', $address_id)->first();

        $cartDescription = collect($this->getCartItems())->mapWithKeys(function ($item) {
            return [$item['amount'] => "{$item['id']} × {$item['amount']}"];
        })->implode(', ');

        return [
            "profile_id" => $this->credentials['profile_id'],
            "tran_type" =>  "sale",
            "tran_class" =>  "ecom",
            "cart_id" => (string) $transaction->id,
            "cart_description" =>  $cartDescription,
            "cart_currency" =>  "EGP",
            "cart_amount" =>  $transaction->total_amount / 100,
            // "callback" =>  $this->credentials['callback_url'], //route('customer.paytabs.callback'),
            "return" => $this->credentials['callback_url'], //route('customer.paytabs.callback'),
            "hide_shipping" =>  true,
            "customer_details" => [
                "name" => $address->customer_full_name,
                "email" => $address->email ?? "no email",
                "street1" => $address->formatted_address,
                "phone" => $address->phone,
                "city" => $address->city->name,
                "country" => "EGY",
                "zip" => "00973"
            ]
        ];
    }
    /**
     * Set credentials of paymob payment
     *
     * @return void
     */
    private function setCredentials($credentials)
    {
        $this->baseUrl = "https://secure-egypt.paytabs.com/";
        $this->profile_id = $credentials['profile_id'];
        $this->callback_url = $credentials['callback_url'];
        $this->server_key = $credentials['server_key'];
    }
    /**
     * Get errors
     *
     * @param int|null $code
     * @return void
     */
    private function getErrors($code = null): string
    {
        $errors = [
            1 => "Authentication failed. Check authentication header.",
            113 => "Invalid transaction reference"
        ];
        return $errors[$code] ?? "Invalid error";
    }
}
