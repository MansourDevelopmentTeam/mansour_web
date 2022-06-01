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
use Facades\App\Models\Services\OrdersService;
use App\Exceptions\TransactionNotFoundException;
use Facades\App\Models\Repositories\CartRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class QnbSimplifyPayment
{
    private $publicKey;
    private $privateKey;

    private $client;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->client = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);

    }

    /**
     * Get url iframe pay
     *
     * @param [type] $totalAmount
     * @param [type] $orderData
     * @param [type] $itemsPrice
     * @return void
     */
    public function Pay($totalAmount, $orderData, $itemsPrice = null, $user = null)
    {
        $this->setCredentials($orderData['payment_method']);
        $transaction = $this->CreateTransaction($totalAmount, null, $orderData, $user);
        if (!$transaction) {
            return false;
        }
        return url('api/customer/orders/payment-view/' . $transaction->id);
    }

    public function PayView(Transaction $transaction)
    {
        $orderData = $transaction->order_details;
        $this->setCredentials($orderData['payment_method']);
        $callBackUrl = url('api/customer/orders/qnb-simplify/receipt/' . $transaction->id);
        return view('payment.qnb_simplify', ['transaction' => $transaction, 'public_key' => $this->publicKey, 'call_back_url' => $callBackUrl]);
    }

    public function responseCallBack(Transaction $transaction, $paymentResponseData)
    {
        $orderData = $transaction->order_details;
        $this->setCredentials($orderData['payment_method']);
        $validatePayment = $this->validatePayment($paymentResponseData);
        if (!$validatePayment) {
            return false;
        }
        $transactionData = [
            'transaction_response' => $paymentResponseData,
            'transaction_status' => $paymentResponseData['paymentStatus'] === "APPROVED" ? true : false,
        ];
        $transaction->update($transactionData);
        if ($transaction->transaction_status == Transaction::TRANSACTION_STATUS_SUCCESS){

        }

        return $transaction;
    }

    public function validatePayment($paymentResponseData)
    {
        $amount = $paymentResponseData['amount'];
        $reference = $paymentResponseData['reference'];
        $paymentId = $paymentResponseData['paymentId'];
        $paymentDate = $paymentResponseData['paymentDate'];
        $paymentStatus = $paymentResponseData['paymentStatus'];
        $privateKey = $this->privateKey;
        $recreatedSignature = strtoupper(md5($amount . $reference . $paymentId . $paymentDate . $paymentStatus . $privateKey));
        if ($recreatedSignature !== $paymentResponseData['signature']) {
            return false;
        }
        return true;
    }

    /**
     * Create tranaction
     *
     * @param int $totalAmount
     * @param int $orderPayId
     * @param array $orderData
     * @return Transaction
     */
    private function CreateTransaction($totalAmount, $orderPayId, $orderData, $user = null)
    {
        $items = CartRepository::getUserCartItems();
        is_array($items) ? $items : $items->toArray();
        $orderData['items'] = $items;
        $data = [
            'order_details' => $orderData,
            'payment_method_id' => $orderData['payment_method'],
            'order_pay_id' => $orderPayId,
            'total_amount' => $totalAmount,
            'customer_id' => $user ? $user->id : null,
            'user_agent' => OrdersService::getUSerAgent(isset($orderData['device_type']) ? $orderData['device_type'] : null)
        ];
        return Transaction::create($data);
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
        $this->publicKey = $credentials['public_key'];
        $this->privateKey = $credentials['private_key'];
    }
}
