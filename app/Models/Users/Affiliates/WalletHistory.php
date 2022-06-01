<?php

namespace App\Models\Users\Affiliates;

use App\Models\Orders\Order;
use App\Models\Orders\OrderState;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    protected $fillable = ['affiliate_id', 'amount', "type", "status", "order_id", "due_date", "payment_method", "phone_number", "bank_name", "account_name", "account_number", "iban", "admin_comment", "rejection_reason"];

    public function affiliate()
    {
        return $this->belongsTo(User::class, "affiliate_id");
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getTypeStringAttribute()
    {
        $attribute = null;
        if ($this->type == 1) {
            $attribute = 'Order';
        } elseif ($this->type == 2) {
            $attribute = 'Admin Credit';
        } elseif ($this->type == 3) {
            $attribute = 'WithDraw Request';
        }
        return $attribute;
    }

    public function getStatusStringAttribute()
    {
        $attribute = null;
        if ($this->status == 0) {
            $attribute = 'Pending';
        } elseif ($this->status == 1) {
            $attribute = 'Approved';
        } elseif ($this->status == 2) {
            $attribute = 'Rejected';
        }
        return $attribute;
    }

    public function validatedStatus()
    {
        $attribute = null;
        if ($this->type == 1) {
            if ($this->order && strtotime($this->due_date) <= strtotime(now())) {
                if ($this->order->state_id === OrderState::DELIVERED){
                    $attribute = 1;
                }else{
                    $attribute = 0;
                }
            } else {
                $attribute = 0;
            }
        } else {
            $attribute = $this->status;
        }
        return $attribute;
    }
}
