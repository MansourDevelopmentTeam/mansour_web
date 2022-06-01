<?php
namespace App\Classes\Payment\Drivers;

use Illuminate\Support\Arr;
use App\Contracts\PaymentMethod;
use App\Models\Orders\Transaction;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Models\Repositories\TransactionRepository;

class UpgMethod extends Method implements PaymentMethod
{
    /**
     * UpgMethod constructor.
     *
     * @param Array $config
     */
    public function __construct(Array $config)
    {
        parent::__construct($config);
        $this->setResponseCode(203);
        $this->setCredentials($config['credentials']);
    }
    /**
     * Set we accept payment service
     *
     * @return void
     */
    public function setPaymentService()
    {
        $this->paymentService = app()->make('App\Models\Services\UpgPayment');
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
        // return $this->paymentService->pay($transaction);

        $user = auth()->user();
        $token = null;
        if ($user) {
            $token = JWTAuth::fromUser($user);
        }
        
        $totalAmount = $transaction->total_amount;
        $dateTime = $this->dateTimeLocalTrxn;
        $string = "Amount={$totalAmount}&DateTimeLocalTrxn={$dateTime}&MerchantId={$this->mID}&MerchantReference={$transaction->id}&TerminalId={$this->tID}";
        $secureHash = hash_hmac("sha256", $string, hex2bin($this->secureKey));
        $secureHash = strtoupper($secureHash);

        return view("payment.upg", [
            "mID" => $this->mID,
            "tID" => $this->tID,
            "secureHash" => $secureHash,
            "amount" => $totalAmount,
            "order_id" => $transaction->id,
            "trxDateTime" => $dateTime,
            "returnUrl" => url('api/customer/orders/receipt/' . $transaction->id . '?token=' . $token)
        ]);
    }
    /**
     * Complete payment
     *
     * @param Transaction $transaction
     * @return void
     */
    public function completePayment($transaction)
    {
        $secureHash = request()->SecureHash;

        $responseData = Arr::except(request()->all(), [
            'payment_method',
            'transaction_id',
            'token',
            'SecureHash',
            'NetworkReference',
            'PayerAccount',
            'PayerName',
            'ProviderSchemeName',
            'SystemReference',
            'success',
            'data'
        ]);

        $responseData['MerchantId'] = $this->mID;
        $responseData['TerminalId'] = $this->tID;
        ksort($responseData);
        $string = [];
        foreach ($responseData as $key => $value) {
            $string[] = "{$key}={$value}";
        }
        $string = implode("&", $string);
        Log::info("UPG Method string: " . $string);
        $generatedHash = hash_hmac("sha256", $string, hex2bin($this->secureKey));
        $generatedHash = strtoupper($generatedHash);

        $isSuccess = $generatedHash == $secureHash && request()->success == 0;
        $transaction->update([
            'transaction_response' => request()->all(),
            'payment_reference' => request()->get('SystemReference'),
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
     * Set credentials of bank payment
     *
     * @param array $payment
     * @param int $plan_id
     * @return void
     */
    private function setCredentials($credentials)
    {
        $this->mID = $credentials['merchant_id'];
        $this->tID = $credentials['terminal_id'];
        $this->secureKey = $credentials['secure_key'];
        $this->dateTimeLocalTrxn = date("YmdHis");
    }
    /**
     * Get errors
     *
     * @param int|null $code
     * @return void
     */
    private function getErrors($response): string
    {
        return "Invalid error";
    }
}
