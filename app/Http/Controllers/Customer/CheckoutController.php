<?php

namespace App\Http\Controllers\Customer;

use Exception;
use App\Facade\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Orders\Transaction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Services\OrdersService;
use App\Models\Transformers\CustomerOrderTransformer;
use App\Http\Requests\Customer\Order\CreateOrderRequest;
use App\Services\Facebook\ConversionAPI;

class CheckoutController extends Controller
{
    protected $orderService;

    private $conversionApi;

    public function __construct(OrdersService $orderService, ConversionAPI $conversionApi)
    {
        $this->orderService = $orderService;
        $this->conversionApi = $conversionApi;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param CreateOrderRequest $request
     * @return Response
     */
    public function store(CreateOrderRequest $request, CustomerOrderTransformer $orderTrans)
    {
        $validator = $this->orderService->validateOrder($request->all(), auth()->user(), $request->header("lang"));
        // validate request
        if (!$validator->valid()) {
            $error = $validator->errors()->first();
            return $this->errorResponse($error->getMessage(), "Invalid data", $validator->errors(), $error->getCode());
        }
        $payment_method_id = $request->get('payment_method');
        $payment = Payment::store($payment_method_id);
        try {
            if ($payment->isOnline()) {
                $payUrl = $payment->getPaymentUrl();
                return $this->jsonResponse("Success", ['pay_url' => $payUrl], $payment->getResponseCode());
            }

            // attach user-ip to request data for creating transaction data later
            $request->merge(['user_ip' => getRealIp()]);

            $order = $this->orderService->createOrder($request->all(), null, auth()->User(), null, $request->use_wallet);
            $msg = $payment->completePayment();
//            try {
//                $this->conversionApi->send($order);
//            } catch (\Exception $exception) {
//                Log::error("Conversion Api Message: " . $exception->getMessage());
//            }
            return $this->jsonResponse($msg, $orderTrans->transform($order), $payment->getResponseCode());
        } catch (Exception $e) {
            Log::error("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            return $this->errorResponse("Error happened when creating order", "Invalid error", []);
        }
    }

    /**
     * Show payment page.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        $user = auth()->user();

        try {
            $transaction = Transaction::where('id', $id)->where('customer_id', $user->id ?? null)->firstOrFail();

            $payment = Payment::store($transaction->payment_method_id);
            return $payment->paymentView($transaction);
        } catch (\Exception $e) {
            return redirect(config('app.website_url') . '/checkout/final-receipt?is_success=false&message=Transaction not complete successfully');
        }
    }
}
