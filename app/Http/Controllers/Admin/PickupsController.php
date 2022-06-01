<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Shipping\ShippingFactory;
use App\Models\Orders\OrderState;
use App\Models\Services\AramexServiceV2;
use App\Models\Shipping\OrderPickup;
use App\Models\Shipping\ShippingMethods;
use Octw\Aramex\Aramex;
use Illuminate\Http\Request;
use App\Models\Shipping\Pickup;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Services\AramexService;
use App\Http\Resources\Admin\PickupResource;

class PickupsController extends Controller
{
    protected $aramexService;
    private $shippingFactory;

    public function __construct(AramexService $aramexService, ShippingFactory $shippingFactory)
    {
        $this->aramexService = $aramexService;
        $this->shippingFactory = $shippingFactory;
    }

    public function index(Request $request)
    {
        $pickups = Pickup::with("order_pickups")->orderBy("created_at", "DESC")->get();

        return $this->jsonResponse("Success", $pickups);
    }

    public function show($id)
    {

        $pickup = Pickup::with("order_pickups", "orders")->findOrFail($id);

//        $orderPicUpsShippingIDS = $pickup->order_pickups->pluck('shipping_id')->toArray();

        $orderPickups = $pickup->order_pickups;
        //dd("dd", $this->aramexServiceV2->checkShipmentStatus(1));

        foreach ($orderPickups as $orderPickup) {
            $state = $this->shippingFactory::make(ShippingMethods::ARAMEX)->checkShipmentStatus($orderPickup->shipping_id);

            //$state = $this->aramexService->getShipmentState($orderPickup->shipping_id);

            $orderPickup->update(["update_description" => $state["UpdateDescription"], "status" => $state["UpdateCode"]]);
            if (OrderPickup::PICKUP_CANCELLED == $state['UpdateCode']) {
//                $orderPickup->order()->update(['state_id' => OrderState::CANCELLED]);
            } elseif (OrderPickup::PICKUP_RETURNED == $state['UpdateCode']) {
                $orderPickup->order()->update(['state_id' => OrderState::DELIVERY_FAILED]);
            } elseif (OrderPickup::PICKUP_DELIVERED == $state['UpdateCode']) {
                $orderPickup->order()->update(['state_id' => OrderState::DELIVERED]);
            } elseif (OrderPickup::PICKUP_RECEIVED_AT_ORIGIN_FACILITY == $state['UpdateCode']) {
                $orderPickup->order()->update(['state_id' => OrderState::ONDELIVERY]);
            }
        }
//        $orderPicUpsShippingIDS = array_map(function($value) {return (string)$value;}, $orderPicUpsShippingIDS);
//        dd($data);
        return $this->jsonResponse("Success", new PickupResource($pickup));
    }
}
