<?php

namespace App\Models\Orders;

use App\Models\Users\User;
use App\Models\Orders\Order;
use App\Models\Users\Address;
use App\Models\Payment\Invoice;
use App\Models\Users\Deliverer;
use App\Models\Products\Product;
use App\Models\Orders\OrderSchedule;
use Illuminate\Support\Facades\Lang;
use App\Models\Payment\PaymentMethod;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    const TRANSACTION_STATUS_PENDING = 0;
    const TRANSACTION_STATUS_SUCCESS = 1;
    const TRANSACTION_STATUS_FAILURE = 2;

    protected $fillable = [
        "order_details", 
        "payment_transaction",
        "order_pay_id", 
        "card_info",
        "transaction_response", 
        "transaction_processe", 
        "transaction_status",
        "total_amount",
        "customer_id",
        "session",
        "success_indicator", 
        "transaction_request", 
        "payment_method_id", 
        "payment_reference",
        "weaccept_transaction_id"
    ];
    protected $casts = [
        "order_details"=>"json",
        "transaction_response"=>"json"
    ];
    
    public function customer()
    {
    	return $this->belongsTo(User::class, "customer_id");
    }

    /**
     * Get the payment method that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Get the order associated with the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function getOrderLinkAttribute()
    {
        $adminLink = config('constants.admin_url');

        return "{$adminLink}/pages/orders/order-details/{$this->order_id}";
    }

    public function getStatusLabelAttribute($value)
    {
        if($this->transaction_status == self::TRANSACTION_STATUS_PENDING){
            $label = null;//"-";
        }else if($this->transaction_status == self::TRANSACTION_STATUS_SUCCESS) {
            $label = 1;//"Authorized";
        } else{
            $label = 0;//"UnAuthorized";
        }
        return $label;
    }
}
