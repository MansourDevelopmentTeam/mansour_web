<?php

namespace App\Models\Loyality;

use App\Models\Orders\Order;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPoint extends Model
{
    use SoftDeletes;
    
    protected $fillable = ["total_points", "remaining_points", "expired_points", "expiration_date", "activation_date", "order_id", "amount_spent", "referer_id"];

    protected $appends = ["active"];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function referer()
    {
    	return $this->belongsTo(User::class, 'referer_id');
    }

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function redeems()
    {
        return $this->belongsToMany(UserRedeem::class, "redeem_points", "user_point_id", "redeem_id");
    }

    public function getActiveAttribute()
    {
        return $this->activation_date < now();
    }
}
