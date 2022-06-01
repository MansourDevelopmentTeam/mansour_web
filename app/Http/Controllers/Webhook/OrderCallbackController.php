<?php

namespace App\Http\Controllers\Webhook;

use Exception;
use App\Facade\Payment;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Services\OrdersService;
use App\Models\Repositories\TransactionRepository;

class OrderCallbackController extends Controller
{
    protected $orderService;

    protected $transactionRepo;

    public function __construct(OrdersService $orderService, TransactionRepository $transactionRepo)
    {
        $this->orderService = $orderService;
        $this->transactionRepo = $transactionRepo;
    }

    /**
     * We accept the order callback from the payment gateway
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function weAcceptResponse(Request $request)
    {
        try {
            $transaction = $this->transactionRepo->getByOrderPayId($request->order);
        
            $payment = Payment::store($transaction->payment_method_id);
            $order_details = $payment->completePayment($transaction);
    
            if ($order_details['success']) {
                $order = $this->orderService->createOrder($order_details['data'], $transaction->id, $transaction->customer);
    
                return redirect(config('app.website_url') . '/checkout/final-receipt?is_success=true&order_status=' . $order->state->name . '&order_id=' . $order->id);
            }
            return redirect(config('app.website_url') . '/checkout/final-receipt?is_success=false&message=' . $order_details['message']);
        } catch (Exception $e) {
            Log::error("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->errorResponse("Error happened when creating order", "Invalid error", []);
        }
    }

    /**
     * Master card callback response
     *
     * @param int $transactionID
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function masterCardResponse($transactionID)
    {
        $transaction = $this->transactionRepo->getByIdAndCustomer($transactionID);
        try{
            $payment = Payment::store($transaction->payment_method_id);
            $order_details = $payment->completePayment($transaction);

            if ($order_details['success']) {
                $order = $this->orderService->createOrder($order_details['data'], $transaction->id, $transaction->customer);

                return redirect(config('app.website_url') . '/checkout/final-receipt?is_success=true&order_status=' . $order->state->name . '&order_id=' . $order->id);
            }

            return redirect(config('app.website_url') . '/checkout/final-receipt?is_success=false&message=' . $order_details['message']);
        } catch (Exception $e) {
            Log::error("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->errorResponse("Error happened when creating order", "Invalid error", []);
        }
    }

    /**
     * Paytabs callback response
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function paytabsResponse(Request $request)
    {
        $transaction = $this->transactionRepo->getByTransRef($request->tranRef ?? $request->tran_ref);
        try{
            $order = Order::where('transaction_id', $transaction->id)->first();
            if ($order) {
                return redirect(config('app.website_url') . '/checkout/final-receipt?is_success=true&order_status=' . $order->state->name . '&order_id=' . $order->id);
            }
            $payment = Payment::store($transaction->payment_method_id);
            $order_details = $payment->completePayment($transaction);

            if ($order_details['success']) {
                $order = $this->orderService->createOrder($order_details['data'], $transaction->id, $transaction->customer);

                return redirect(config('app.website_url') . '/checkout/final-receipt?is_success=true&order_status=' . $order->state->name . '&order_id=' . $order->id);
            }

            return redirect(config('app.website_url') . '/checkout/final-receipt?is_success=false&message=' . $order_details['message']);
        } catch (Exception $e) {
            Log::error("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            return $this->errorResponse("Error happened when creating order", "Invalid error", []);
        }
    }
}
