<?php

namespace App\Models\Orders;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{

    protected $table = "order_history";

    protected $fillable = ["state_id", "sub_state_id", "user_id", "order_id","status_notes"];
    
    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function state()
    {
    	return $this->belongsTo(OrderState::class);
    }

    public function sub_state()
    {
        return $this->belongsTo(OrderState::class, "sub_state_id");
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
