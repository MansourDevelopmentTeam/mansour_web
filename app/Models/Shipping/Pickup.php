<?php

namespace App\Models\Shipping;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    const PLACED = 1;
    const DELIVERED = 1;
    const CANCELLED = 3;
    protected $fillable = [
        "shipping_method",
        "pickup_time",
        "shipping_id",
        "shipping_guid",
        "notes",
        "status"
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class, "order_pickups", "pickup_id", "order_id");
    }

    public function order_pickups()
    {
        return $this->hasMany(OrderPickup::class, "pickup_id");
    }
}
