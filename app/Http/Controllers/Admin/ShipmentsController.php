<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Shipping\ShippingFactory;
use App\Models\Shipping\ShippingMethods;
use Carbon\Carbon;
use App\Models\Users\User;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Shipping\Pickup;
use App\Models\Users\ContactUs;
use App\Models\Orders\OrderState;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Services\AramexService;
use App\Http\Resources\Admin\ShipmentResource;

class ShipmentsController extends Controller
{
    private $shippingFactory;

    public function __construct(ShippingFactory $shippingFactory, AramexService $aramexService)
    {
        $this->shippingFactory = $shippingFactory;
        $this->aramexService = $aramexService;
    }

    public function getAvailablePickups()
    {
        $pickups = Pickup::where("status", "!=", 3)->where("pickup_time", ">", now())->get();

        return $this->jsonResponse("Success", $pickups);
    }

    public function createPickUp(Request $request, $provider)
    {
        $this->validate($request, [
            "order_ids" => "required|array|filled",
            "branch_id" => "required|integer|exists:users,id",
            "aramex_account_number" => "required|integer|in:1,2",
            "pickup_date" => "required|date|after:now",
            "shipping_notes" => "sometimes|nullable",
        ]);

        // $orders = Order::whereIn('id', (array) $request->order_ids)->get();

        // $options = new \stdClass();
        // $options->pickup_date = Carbon::parse($request->pickup_date)->format("Y-m-d H:i:s");
        // $options->branch_id = $request->branch_id;
        // $options->shipping_notes = $request->shipping_notes;
        // $options->aramex_account_number = $request->aramex_account_number;

        switch ($provider) {
            case 'Aramex':
                $pickup = $this->shippingFactory::make(ShippingMethods::ARAMEX)->createPickup($request->order_ids, Carbon::parse($request->pickup_date)->format("Y-m-d H:i:s"), $request->branch_id, $request->shipping_notes, $request->aramex_account_number);
        }

        if ($pickup === true) {
            return $this->jsonResponse("Success");
        } else {
            return $this->errorResponse($pickup, "Invalid data", $pickup, 422);
        }
    }

    public function createShipment(Request $request, $provider)
    {
        //REFACTOR: shipping refactory
        $this->validate($request, [
            "order_id" => "required|integer|exists:orders,id",
            "branch_id" => "required|integer|exists:users,id",
            "aramex_account_number" => "required|integer|in:1,2",
            // "pickup_date" => "required|date|after:now",
            "shipping_notes" => "sometimes|nullable",
            "pickup_guid" => "sometimes|nullable"
        ]);
        $branch = User::where('id', $request->branch_id)->where('type', 3)->firstOrFail();
        $order = Order::findOrFail($request->order_id);
        // switch ($provider) {
        //     case 'Aramex':
        //         $shipment = $this->aramexService->CreateShipment($request, $branch, $order, $request->get('aramex_account_number'));
        //     }
            
        try {
                //     $options = new \stdClass();
                //     $options->aramex_account_number = $request->get('aramex_account_number');
                //     $options->pickup_guid = $request->get('pickup_guid');
                //     $options->shipping_notes = $request->get('shipping_notes');
                //     $shipment = $this->shippingFactory::make(ShippingMethods::ARAMEX)->createShipment($order, $branch, $options);
            $shipment = $this->aramexService->CreateShipment($request, $branch, $order, $request->get('aramex_account_number'));
            if ($shipment) {
                return $this->jsonResponse("Success", new ShipmentResource($shipment));
            } 
        } catch (\Exception $e) {
            return $this->errorResponse("Invalid data", "Invalid data");
        }
    }

    public function calculateRate(Request $request, $provider)
    {
        switch ($provider) {
            case 'Aramex':
                $this->aramexService->CalculateRate($request);

        }

    }

}
