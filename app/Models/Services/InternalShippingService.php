<?php


namespace App\Models\Services;

use App\Models\Shipping\Pickup;
use App\Models\Shipping\OrderPickup;
use App\Models\Shipping\ShippingMethods;

class InternalShippingService
{

    public function createPickup($order_ids, $notes, $pickup_date)
    {
        $pickUpData = [
            "shipping_method" => ShippingMethods::INTERNAL,
            "notes" => $notes,
            "pickup_time" => $pickup_date,
            "status" => "",
        ];
        
        $pickup = Pickup::create($pickUpData);

        foreach ($order_ids as $id ) {
            $orderPicupData = [
                "pickup_id" => $pickup->id,
                "order_id" => $id,
            ];

            $orderPicup = OrderPickup::create($orderPicupData);
        }
    }
}
