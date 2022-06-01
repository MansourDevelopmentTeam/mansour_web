<?php

namespace App\Models\Services;

use Exception;
use Carbon\Carbon;
use App\Facade\Payment;
use Illuminate\Support\Facades\Http;
use Octw\Aramex\Aramex;
use App\Models\Users\User;
use App\Models\Orders\Order;
use App\Models\Shipping\Pickup;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Models\Shipping\OrderPickup;
use Illuminate\Support\Facades\Date;
use App\Contracts\ShipmentsInterface;
use App\Models\Payment\PaymentMethod;
use App\Models\Shipping\ShippingAreas;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Facades\App\Models\Services\OrdersService;

class QatarPostShippingService implements ShipmentsInterface
{
    private $url;
    private $userName;
    private $password;

    public function __construct()
    {
        $this->url = config('integrations.qatar_post.url');
        $this->userName = config('integrations.qatar_post.username');
        $this->password = config('integrations.qatar_post.password');
    }

    public function getAuthenticationToken(): string
    {
        $response = Http::acceptJson()->withBasicAuth($this->userName, $this->password)->post($this->url . '/shipmentapi/get/token');
        return $response;
    }

    public function createShipment($order, $branch, $options = null)
    {
        $token = $this->getAuthenticationToken();
        if (!$token)
            return false;
        $branchProfile = $branch->delivererProfile;
        $branchCity = $branchProfile->area->aramex_area_name;
        $branchArea = isset($branchProfile->area->aramex_area_name) ? $branchProfile->area->aramex_area_name : '';
        $branchDistricts = isset($branchProfile->districts->name) ? $branchProfile->districts->name : '';
        $customer = $order->customer;
        $customerAddress = $order->address;
        $customerCity = $customerAddress->city->aramex_city_name;
        $customerArea = isset($customerAddress->area->aramex_area_name) ? $customerAddress->area->aramex_area_name : '';
        $customerDistricts = isset($customerAddress->district->name) ? $customerAddress->district->name : '';
        try {
            $requestData = [
                'orderID' => $order->id,
                'subOrderID' => $order->id,
                'trackingNumber' => 'JP-' . $order->id,
                'customerName' => $customer ? $customer->name : $customerAddress->name,
                'customerMobile' => $customer ? $customer->phone : $customerAddress->phone,
                'MerchantName' => config('app.name'),
                'MerchantStore' => $branch->name,
                'MerchantPhone' => $branch->phone,
                'delivery_Zone' => null,
                'delivery_Street' => $customerAddress->landmark,
                'delivery_BuildingNo' => $customerAddress->apartment,
                'delivery_UnitNo' => null,
                'pickup_Zone' => null,
                'pickup_Street' => null,
                'pickup_Building' => null,
                'pickup_Unitno' => null,
                'location_Details' => null,
                'deliveryType' => 'Home Delivery',
                'deliveryScheduletype' => Carbon::now()->addDay()->format('Y-m-d H:i:s'),
                'zoneType' => null,
                'productDiscription' => 'Perfumes',
                'weight' => $order->order_wight,
                'quantity' => $order->order_number_of_pisces,
                'TransectionType' => 1,
                'currentStatus' => 5,
                'createdDate' => Carbon::now(),
            ];

            $response = Http::acceptJson()->withHeaders(['Token' => $token])->post($this->url . 'ShipmentAPI/partner/order/create', $requestData);

            Log::info($response);

        } catch (Exception $exception) {
            // $data = false;
            throw new Exception('Error Creating Shipment, details: ' . $exception->getMessage());
            // return $data;
        }
    }

    public function trackOrdersStatus(array $tackingNumbers)
    {
        $token = $this->getAuthenticationToken();
        if (!$token)
            return false;
        $requestData = [
            'pageNumber' => 1,
            'tackingNumbers' => $tackingNumbers,
        ];
        $response = Http::acceptJson()->withHeaders(['Token' => $token])->post($this->url . 'ShipmentAPI/partner/order/create', $requestData);

    }

}
