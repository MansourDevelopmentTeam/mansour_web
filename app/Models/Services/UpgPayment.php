<?php

namespace App\Models\Services;

use Illuminate\Support\Arr;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Orders\Transaction;
use App\Models\Payment\Qnb\Parser;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Payment\Qnb\api_lib;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Models\Payment\Qnb\Merchant;
use Illuminate\Support\Facades\Auth;
use Facades\App\Models\Repositories\CartRepository;

class UpgPayment
{
    private $authApiKey;
    private $mID;
    private $tID;
    private $secureKey;
    private $dateTimeLocalTrxn;
    private $ordersService;


    public function __construct(OrdersService $ordersService)
    {
        $this->ordersService = $ordersService;
    }


    public function pay($transaction)
    {
        $this->setCredentials($transaction->payment_method_id);

        $user = auth()->User();
        $token = JWTAuth::fromUser($user);
        $totalAmount = $transaction->total_amount;
        $dateTime = $this->dateTimeLocalTrxn;
        $string = "Amount={$totalAmount}&DateTimeLocalTrxn={$this->dateTimeLocalTrxn}&MerchantId={$this->mID}&MerchantReference={$transaction->id}&TerminalId={$this->tID}";
        $secureHash = hash_hmac("sha256", $string, hex2bin($this->secureKey));
        $secureHash = strtoupper($secureHash);
        return view("payment.upg", ["mID" => $this->mID, "tID" => $this->tID, "secureHash" => $secureHash, "amount" => $totalAmount, "order_id" => $transaction->id, "trxDateTime" => $this->dateTimeLocalTrxn, "returnUrl" => URL::to('api/customer/orders/receipt/' . $transaction->id . '?token=' . $token)]);
    }

    public function payCallBack($transaction, $request)
    {
//        dd($request->all());
        $secureHash = $request->SecureHash;
        $transaction->update(['payment_reference' => $request->SystemReference]);
        $user = Auth::user();
        $responseData = Arr::except($request->all(), [
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

        $responseData['MerchantId'] =  $this->mID;
        $responseData['TerminalId'] =  $this->tID;
        ksort($responseData);
        $string = [];
        foreach ($responseData as $key => $value) {
            $string[] = "{$key}={$value}";
        }
        $string = implode("&", $string);
        Log::info($string);
        $generatedHash = hash_hmac("sha256", $string, hex2bin($this->secureKey));
        $generatedHash = strtoupper($generatedHash);
        $successTransaction = $generatedHash == $secureHash && $request->success == 0;
//        dd($string, $responseData, $request->all(), $generatedHash, $secureHash, $successTransaction);
        if ($successTransaction) {
            $transaction->update(['transaction_response' => $request->all(), 'transaction_status' => Transaction::TRANSACTION_STATUS_SUCCESS]);
            $order = Order::where('transaction_id', $transaction->id)->first();
            if (!$order) {
                $order = $this->ordersService->createOrder($transaction->order_details, $transaction->id, $user);
                $url = config('app.website_url') . "/checkout/final-receipt/{$order->id}?success=1";
            }
        } else {
            $transaction->update(['transaction_response' => $request->all(), 'transaction_status' => Transaction::TRANSACTION_STATUS_FAILURE]);
            $url = config('app.website_url') . "/checkout/final-receipt?is_success=false";
        }
        return $url;
    }

    /**
     * Set credentials of upg payment
     *
     * @param int $method_id
     * @return void
     */
    private function setCredentials($method_id)
    {
        $paymentObj = config("payment.stores.{$method_id}");
        $credentials = $paymentObj['credentials'];

        $this->mID = $credentials['merchant_id'];
        $this->tID = $credentials['terminal_id'];
        $this->secureKey = $credentials['secure_key'];
        $this->dateTimeLocalTrxn = date("YmdHis");
    }

    public function CreateTransaction($totalAmount, $orderData)
    {
        $items = CartRepository::getUserCartItems();
        $orderData['items'] = $items->toArray();

        $data = [
            'order_details' => $orderData,
            'order_pay_id' => null,
            'total_amount' => $totalAmount,
            'customer_id' => auth()->User()->id,
        ];
        $transaction = Transaction::create($data);
        return $transaction;
    }
}
