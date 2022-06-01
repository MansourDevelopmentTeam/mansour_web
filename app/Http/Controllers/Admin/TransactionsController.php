<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Facade\Payment;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Orders\Transaction;
use App\Http\Controllers\Controller;
use App\Models\Services\PushService;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Services\OrdersService;
use App\Http\Resources\Admin\TransactionResource;
use App\Sheets\Export\Transactions\TransactionsExport;

class TransactionsController extends Controller
{
    protected $pushService;
    protected $orderService;

    /**
     * Constructor
     *
     * @param PushService $pushService
     * @param OrdersService $orderService
     */
    public function __construct(PushService $pushService, OrdersService $orderService)
    {
        $this->pushService = $pushService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        $transactions = Transaction::with(['customer', "paymentMethod"]);

        if (request()->has('status') &&  request()->status !== null) {
            $transactions->where("transaction_status", request()->status);
        }


        if (request()->has('q') && request()->q !== null) {
            $transactions->where(function ($q) {
                $q->where('payment_reference', request()->q)->orWhereHas("customer", function ($q) {
                    $keyWord = request()->q;
                    $q->where("name", "LIKE", "%{$keyWord}%")->orWhere("phone", "LIKE", "%{$keyWord}%");
                });
            });
        }

        if (request()->date_from) {
            $transactions->whereDate("created_at", ">=", request()->date_from);
        }

        if (request()->date_to) {
            $transactions->whereDate("created_at", "<=",  request()->date_to);
        }
        
        $transactions = $transactions->orderBy("created_at", "DESC")->paginate(20);
        return $this->jsonResponse("Success", ["transactions" => TransactionResource::collection($transactions),"total" => $transactions->total()]);
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return $this->jsonResponse("Success", new TransactionResource($transaction));
    }

    public function export()
    {
        $fileName = 'transactions_' . auth()->user()->name . '_' . date("Y_m_d H_i_s") . '.xlsx';
        $fileStorePath = 'public/exports/transactions/' . $fileName;
        Excel::store(new TransactionsExport(), $fileStorePath);

        $filePath = url('storage/exports/transactions').'/'.$fileName;
        $this->pushService->notifyAdmins('File Exported ', 'Your export has completed! You can download the file from', '', 11, $filePath, \Auth::id());

        return $this->jsonResponse('Success');
    }
    /**
     * Create order from transaction
     *
     * @param \App\Models\Orders\Transaction $transaction
     * @return void
     */
    public function createOrder(Transaction $transaction, OrdersService $orderService)
    {
        $order = Order::where('transaction_id', $transaction->id)->first();
        if ($order) {
            return $this->errorResponse("Order already created", "Invalid data", 422);
        }

        try {
            $paymentVerify = Payment::store($transaction->payment_method_id)->verify($transaction);

            if ($paymentVerify) {
                $order = $orderService->createOrder($transaction->order_details, $transaction->id, $transaction->customer);
                if ($order) {
                    $transaction->load(['customer', 'order']);
                    return $this->jsonResponse("Success",  new TransactionResource($transaction));
                }
            }
            $msg = "The transaction has not been paid yet";
        } catch (\Exception $e) {
            $msg = $e->getMessage();
        }

        return $this->errorResponse($msg, "Invalid data", 404);
    }
}
