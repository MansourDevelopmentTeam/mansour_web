<?php


namespace App\Classes\Payment\Drivers;

use Exception;
use App\Contracts\PaymentMethod;
use App\Models\Orders\Transaction;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Payment\PaymentInstallment;
use App\Models\Repositories\TransactionRepository;

class MasterCardMethod extends Method implements PaymentMethod
{
    const STATUS_APPROVED = 'APPROVED';
    const RESPONSE_SUCCESS = 'SUCCESS';

    /**
     * MasterCardMethod constructor.
     *
     * @param Array $config
     */
    public function __construct(Array $config)
    {
        parent::__construct($config);
        $this->transactionRepo = new TransactionRepository;
        $this->setResponseCode(203);
    }
    /**
     * Set we accept payment service
     *
     * @return void
     */
    public function setPaymentService()
    {
        $this->paymentService = app()->make('App\Models\Services\BankPayment');
    }
    /**
     * Get redirect payement url
     *
     * @return void
     */
    public function getPaymentUrl()
    {
        $totalPayArr = $this->getTotalPay();

        $userToken = (string) JWTAuth::getToken();

        $transaction = $this->transactionRepo->create($totalPayArr['grand_total']);

        $pay = url('/api/customer/orders/payment-view/' . $transaction->id . '?token=' . $userToken);

        return $pay;
    }

    /**
     * Get payement view
     *
     * @return void
     */
    public function paymentView($transaction)
    {
        // $this->paymentService = app()->make('App\Models\Services\BankPayment');
        // return $this->paymentService->payOrder($transaction);
        $this->setCredentials($this->config, $transaction->order_details['plan_id']);

        $user = auth()->user();
        $token = null;
        if ($user) {
            $token = JWTAuth::fromUser($user);
        }

        $postRequest = [
            'apiOperation' => 'CREATE_CHECKOUT_SESSION',
            'order' => [
                'id' => $transaction->id,
                'amount' => $transaction->total_amount / 100,
                'currency' => 'EGP'
            ]
            // ,
            // 'interaction' => [
            //     'operation' => 'AUTHORIZE'
            // ]
        ];

        try {
            $response = Http::withBasicAuth($this->username, $this->password)
                ->post($this->baseUrl . "/merchant/{$this->merchantId}/session", $postRequest);

            $result = $response->json();

            if (isset($result['result']) && $result['result'] == self::RESPONSE_SUCCESS) {
                $session_id = $result['session']['id'];

                $transaction->update([
                    'session' => $session_id,
                    "payment_transaction" => $transaction->id,
                    'success_indicator'=> $result['successIndicator'],
                    'transaction_request' => $postRequest,
                    'transaction_status' => Transaction::TRANSACTION_STATUS_SUCCESS,
                ]);

                return view("payment.checkout", [
                    "merchantId" => $this->merchantId,
                    "checkoutJs" => $this->checkoutJs,
                    "transaction" => $transaction,
                    "customerId" => $transaction->customer_id,
                    "order_currency" => "EGP",
                    "session_id" => $session_id,
                    "token" => $token
                ]);
            } else {
                Log::error("Error in creating session for transaction {$transaction->id} # " . json_encode($result));
                throw new Exception("BANK INSTALLMENT ERROR");
            }
        } catch (Exception $e) {
            $postRequest['username'] = $this->username;
            $postRequest['password'] = $this->password;
            $transaction->update([
                'transaction_request' => $postRequest,
                'transaction_status' => Transaction::TRANSACTION_STATUS_FAILURE,
            ]);

            throw $e;
        }
    }
    /**
     * Complete payment
     *
     * @param Transaction $transaction
     * @return void
     */
    public function completePayment($transaction)
    {
        $resultIndicator = request()->resultIndicator;
        $isSuccess = $resultIndicator == $transaction->success_indicator;
        $transaction->update([
            'transaction_response' => request()->all(),
            'transaction_status' => $isSuccess ? Transaction::TRANSACTION_STATUS_SUCCESS : Transaction::TRANSACTION_STATUS_FAILURE,
        ]);

        return [
            'success' => $isSuccess,
            'message' => $isSuccess ? "Success" : "Transaction did not completed",
            'data' => $isSuccess ? $transaction->order_details : []
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
        $response = $this->retrieveOrder($transaction);

        if (isset($response['result']) && $response['result'] == self::RESPONSE_SUCCESS) {
            $success = data_get($response, 'transaction.0.response.gatewayCode') == self::STATUS_APPROVED;
            $transaction->update(['transaction_response' => $response, 'transaction_status' => $success ? Transaction::TRANSACTION_STATUS_SUCCESS : Transaction::TRANSACTION_STATUS_FAILURE]);

            return $success;
        }

        Log::error('MasterCard method error ' . $this->getErrors($response ?? null));
        return false;
    }

    /**
     * Calculate the order grand total to aramex.
     *
     * @param Order $order
     * @return array
     */
    public function getAramexOrderTotal($order): array
    {
        //TODO: Get aramex data from payment table
        $grandTotal = 0;
        $paymentService = '';
        
        return [$grandTotal, $paymentService];
    }
    /**
     * Retrieve Order from mastercard
     *
     * @param [type] $transaction
     * @return void
     */
    public function retrieveOrder($transaction)
    {
        if ($transaction == null) {
            return [];
        }

        $this->setCredentials($this->config, $transaction->order_details['plan_id']);

        try {
            $response = Http::withBasicAuth($this->apiUsername, $this->password)
                    ->get("{$this->baseUrl}/merchant/{$this->merchantId}/order/{$transaction->id}");

            return $response->json();
        } catch (\Exception $e) {
            Log::error("MasterCard method retrieveOrder error . " . $e->getMessage());
        }
        return [];
    }
    /**
     * Set credentials of bank payment
     *
     * @param array $payment
     * @param int $plan_id
     * @return void
     */
    private function setCredentials($payment, $plan_id)
    {
        $credentials = $payment['credentials'];

        if ($payment['isInstallment']) {
            $plan = Cache::remember("payment.plan.{$plan_id}", 60 * 30, function () use ($plan_id) {
                return PaymentInstallment::find($plan_id);
            });

            if ($plan == null) {
                throw new Exception("Plan not found");
            }

            $username = $plan->username;
            $merchant_id = $plan->merchant_id;
            $password = $plan->password;
        } else {
            $username = $credentials['username'];
            $merchant_id = $credentials['merchant_id'];
            $password = $credentials['password'];
        }

        $this->baseUrl = $credentials['base_url'];
        $this->checkoutJs = $credentials['checkout_js'];
        $this->username = $username;
        $this->merchantId = $merchant_id;
        $this->password = $password;
    }

    /**
     * Get errors
     *
     * @param int|null $code
     * @return void
     */
    private function getErrors($response): string
    {
        return data_get($response['detail'], 'error.explanation') ?? "Invalid error";
    }
}
