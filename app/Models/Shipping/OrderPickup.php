<?php

namespace App\Models\Shipping;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;

class OrderPickup extends Model
{
    const PICKUP_CREATED = 'SH014';
    const PICKUP_RECEIVED_AT_ORIGIN_FACILITY = 'SH047';
    const PICKUP_UP_FROM_SHIPPER = 'SH012';
    const PICKUP_CANCELLED = 'SH313';
    const PICKUP_RETURNED = 'SH069';
    const PICKUP_DELIVERED = 'SH005';
    const PICKUP_COLLECTED = 'SH006';
    const PICKUP_COD_RECIEVED = 'SH382';

    protected $fillable = [
        'pickup_id',
        'order_id',
        'shipping_id',
        'foreign_hawb',
        'shipment_url',
        'update_description',
        'tracking_result',
        'status',
    ];

    protected $casts = ['tracking_result' => 'json'];

    public function pickup()
    {
        return $this->belongsTo(Pickup::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
