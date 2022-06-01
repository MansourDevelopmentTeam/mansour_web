<?php

namespace App\Models\Services;

use App\Contracts\ShipmentsInterface;
use GuzzleHttp\Client;
use App\Models\Users\User;
use App\Models\Orders\Order;
use Illuminate\Http\Request;
use App\Models\Shipping\Pickup;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use App\Models\Shipping\OrderPickup;
use App\Models\Payment\PaymentMethods;
use Illuminate\Support\Facades\Storage;
use Facades\App\Models\Services\PushService;

class BostaService implements ShipmentsInterface
{
    private $secureKey;
    private $url;

    public function __construct()
    {
        $credentials = $this->getCredentials('bosta');
        $this->secureKey = $credentials['access_key'];
        if ($credentials['live']) {
            $this->url = "http://api.bosta.co/api/v0";
        } else {
            $this->url = "https://stg-app.getbosta.com/api/v0";
        }
    }

    public function createShipment($order, $branch)
    {
        if (!$order->address->city->bosta_city_name) {
            throw new \Exception("Invalid City", 1);
        }

        $options = $this->deliveryOptions($order, $order->address, $order->customer, $order->shipping_notes);
        Log::info($options);
        $client = new Client();
        $url = "{$this->url}/deliveries";
        $response = $client->post($url, $options);
        $responses[] = $finalOutput = json_decode($response->getBody()->getContents());
        $this->logResponse($url, $finalOutput, $options, 'Bosta-create');
        if (optional($finalOutput)->success !== false) {
            Log::channel('shipping')->info((array)$finalOutput);
            $pdf = "public/shipments/bosta-" . $order->id . ".pdf";
            $airwayBill = $client->get("{$this->url}/deliveries/awb/{$finalOutput->_id}", $options);
            $airwayBillBase64 = json_decode($airwayBill->getBody()->getContents());
            Storage::put($pdf, base64_decode($airwayBillBase64->data));
            $url = Storage::url($pdf);

            $request = new \stdClass();
            $request->shipping_method = 4;
            $request->shipping_id = $finalOutput->_id;
            $request->tracking_result = $finalOutput->trackingNumber;
            $request->shipment_url = url($url);
            $request->order_id = $order->id;
            $request->shipping_notes = $order->shipping_notes;

            return $this->createOrderPickup($request);
        } else {
            Log::channel("shipping")->info("Bosta-failed shipment: \n" . json_encode($finalOutput));
            PushService::notifyAdmins("shipment not created", "Order no. {$order->id} not shipped with bost shipping service", null, null, json_encode($finalOutput));
            return $finalOutput;
        }
    }

    public function createPickUp($request)
    {
        $branch = User::find($request->branch_id);
        $options = [
            'http_errors' => false,
            'headers' => ['Authorization' => $this->secureKey],
            'json' => [
                "businessLocationId" => env("BOSTA_LOCATION_ID"),
                "notes" => (string)$request->shipping_notes,
                "scheduledDate" => date("Y-m-d", strtotime($request->pickup_date)),
                "scheduledTimeSlot" => "13:00 to 16:00",
                "contactPerson" => [
                    "name" => $branch->name,
                    "phone" => $branch->phone,
                    "email" => $branch->email
                ]
            ]
        ];

        $orders = Order::whereIn('id', $request->order_ids)->with(['customer', 'address.city', 'address.area', 'items.product', 'invoice'])->get();
        $failedDeliverers = [];
        foreach ($orders as $order) {
            try {
                $pickupOrderRow = $this->createShipment($order, $branch);
                if (!($pickupOrderRow instanceof OrderPickup)) {
                    $failedDeliverers[] = $order;
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        $client = new Client();
        $url = "{$this->url}/pickups";
        $response = $client->post($url, $options);
        $responses[] = $finalOutput = json_decode($response->getBody()->getContents());
        $this->logResponse($url, $finalOutput, $options, 'Bosta-pickup', $request);
        if (optional($finalOutput)->success !== false) {
            $request->request->add([
                'shipping_method' => 4,
                'shipping_id' => $finalOutput->message->_id,
            ]);
            $pickup = $this->createPickupRow($request);
            // $request->request->add(['pickup_id' => $pickup->id]);
            $request->pickup_id = $pickup->id;
            // $orders = Order::whereIn('id', $request->order_ids)->with(['customer', 'address.city', 'address.area', 'items.product', 'invoice'])->get();
            // $failedDeliverers = [];
            // foreach ($orders as $order) {
            //     $pickupOrderRow = $this->createDelivery($request, $order);
            //     if (!($pickupOrderRow instanceof OrderPickup)) {
            //         $failedDeliverers[] = $finalOutput;
            //     }
            // }
            if (empty($failedDeliverers)) {
                return true;
            } else {
                Log::channel("shipping")->info("Bosta-failed-deliverers: \n" . json_encode($failedDeliverers));
                return false;
            }
        } else {
            Log::channel("shipping")->info("Bosta-failed: \n" . json_encode($finalOutput));
            // PushService::notifyAdmins("Pickup not created", "Pickup not created with bosta shipping service", null, null, json_encode($finalOutput));
            return optional($finalOutput)->message;
        }
    }

    public function CancelPickup($pickupID)
    {
        $pickup = Pickup::find($pickupID);
        $options = [
            'http_errors' => false,
            'headers' => ['Authorization' => $this->secureKey],
        ];
        $client = new Client();
        $url = "{$this->url}/pickups/{$pickup->shipping_id}";
        $response = $client->delete($url, $options);
        $finalOutput = json_decode($response->getBody()->getContents());
        $this->logResponse($url, $finalOutput, $options, 'Bosta-cancel');
        if (optional($finalOutput)->success !== false) {
            $pickup->update([
                'status' => 3
            ]);
            return true;
        }
        return false;
    }

    public function getDeliveryFees($address, $cart)
    {
        return 0;
    }

    public function checkShipmentStatus($shipmentId)
    {
        $request = [
            'http_errors' => false,
            //'headers' => ['Authorization' => $this->secureKey],
            'headers' => ['Authorization' => '75a6f7d2d7c5c3482ea5f7cf9d977a43c6a9eb8ca9e916001fa2439357505a95'],
        ];

        $url = "{$this->url}/deliveries/{$shipmentId}";
        $url = "http://api.bosta.co/api/v0/deliveries";

        $client = new Client();
        $response = $client->get($url, $request);

        $finalOutput = json_decode($response->getBody()->getContents());

        $response = $this->client($url, $request);
dd($finalOutput);
        return $finalOutput;
    }

    public function updatePickup(Pickup $pickup)
    {
        $options = [
            'http_errors' => false,
            'headers' => ['Authorization' => $this->secureKey],
        ];
        $client = new Client();
        $url = "{$this->url}/deliveries/{$pickup->shipping_id}";
        $response = $client->get($url, $options);
        $finalOutput = json_decode($response->getBody()->getContents());
        $this->logResponse($url, $finalOutput, $options, 'Bosta-update');
        if (optional($finalOutput)->maskedState) {
            $pickup->update([
                'status' => $finalOutput->maskedState !== 'Canceled' ? 2 : 3
            ]);
            return true;
        }
        return false;
    }

    private function deliveryOptions($order, $address, $consignee, $shipping_notes)
    {
        $bostaCityName = $address->city->shippingCities()->where('method_id', 4)->first();
        $items = $order->items()->with('product')->get();
        if ($consignee && $consignee->type == 4) {
            $consigneeName = $address->name;
            $consigneePhone = $address->phone;
        } else if ($consignee) {
            $consigneeName = $consignee->name . " " . $consignee->last_name;
            $consigneePhone = $order->phone;
        } else {
            $consigneeName = optional($consignee)->name != "" ? optional($consignee)->name : $address->name;
            $consigneePhone = optional($consignee)->phone ?? $address->phone;
        }
        $affiliate = optional($order->affiliate)->name;
        return [
            'http_errors' => false,
            'headers' => ['Authorization' => $this->secureKey],
            'json' => [
                "type" => 10,
                "specs" => [
                    "size" => "SMALL",
                    "packageDetails" => [
                        "itemsCount" => $this->getItemsAttr($items, 'amount'),
                        "description" => trim($this->getItemsDescription($items), ','), // item1 x 3, item1 x 7,
                    ]
                ],
                "returnSpecs" => [
                    "size" => "SMALL",
                    "packageDetails" => [
                        "itemsCount" => $this->getItemsAttr($items, 'amount'),
                        "description" => trim($this->getItemsDescription($items), ','), // item1 x 3, item1 x 7,
                    ]
                ],
                "notes" => $shipping_notes ?? "",
                "cod" => $order->payment_method == PaymentMethods::VISA ? 0 : $this->getOrderInvoiceAmount($order),// visa = 0 , cash = get invoice amount -- total or discount if found,
                "dropOffAddress" => [
                    "firstLine" => $address->address,
                    "secondLine" => $address->landmark ?? "",
                    "floor" => $address->floor,
                    "apartment" => $address->apartment,
                    "city" => optional($address->city)->bosta_city_name ?? "",
                    "zone" => optional($address->area)->bosta_area_name_en ?? "",
                    "district" => optional($address->district)->name_ar ?? "",
                ],
                "returnAddress" => [
                    "firstLine" => $address->address,
                    "secondLine" => $address->landmark ?? "",
                    "floor" => $address->floor,
                    "apartment" => $address->apartment,
                    "city" => optional($bostaCityName)->name ?? "",
                    "zone" => optional($address->area)->name_ar ?? "",
                    "district" => optional($address->district)->name_ar ?? "",
                ],
                "allowToOpenPackage" => true,
                "businessReference" => "{$affiliate}-{$order->id}",
                'webhookUrl' => URL::to('') . '/api/admin/pickups/bosta/callback',
                // 'webhookUrl' => 'https://ff5de13675f8.ngrok.io/api/admin/pickups/bosta/callback',
                "receiver" => [
                    "firstName" => explode(" ", $consigneeName, 2)[0],
                    "lastName" => isset(explode(" ", $consigneeName, 2)[1]) ? explode(" ", $consigneeName, 2)[1] : "",
                    "phone" => $consigneePhone,
                ]
            ],
        ];

    }

    private function getItemsAttr($items, $attr)
    {
        return array_reduce($items->toArray(), function ($carry, $item) use ($attr) {
            $carry += $item[$attr];
            return $carry;
        });
    }

    private function getOrderInvoiceAmount($order)
    {
        return ($order->invoice->discount ?? $order->invoice->total_amount) + $order->invoice->delivery_fees;
    }

    private function getItemsDescription($items)
    {
        $description = array_reduce($items->toArray(), function ($carry, $item) {
            $carry = "{$carry} {$item['product']['name_ar']} × {$item['amount']},";
            return $carry;
        });
        return trim($description);
    }

    public function getCities()
    {
        $client = new Client();
        $url = "{$this->url}/cities";
        $options = [
            'http_errors' => false,
            'headers' => ['Authorization' => $this->secureKey],
        ];
        $request = $client->get($url, $options);
        $response = json_decode($request->getBody()->getContents(), true);
     
        return $response;
    }

    public function getZones($id = null)
    {
        $client = new Client();
        $url = "{$this->url}/zones";
        $options = [
            'http_errors' => false,
            'headers' => ['Authorization' => $this->secureKey],
            'query' => [
                'cityId' => $id
            ]
        ];

        $request = $client->get($url, $options);
        $response = json_decode($request->getBody()->getContents(), true);
     
        return $response;
    }

    public function logResponse($url, $finalOutput, $options, $method, $request = null)
    {
        Log::channel("shipping")->info(
            "{$method}: \n" .
            json_encode([
                'requestData' => $request,
                'paymentData' => [
                    'url' => $url,
                    'response' => $finalOutput,
                    'request' => $options,
                ],
            ])
        );
    }

    public function createPickupRow($request)
    {
        $pickUpData = [
            "shipping_method" => $request->shipping_method,
            "notes" => $request->shipping_notes,
            "pickup_time" => date("Y-m-d", strtotime($request->pickup_date)) . " 13:00:00" ,
            "status" => 1,
            "shipping_id" => $request->shipping_id,
            "shipping_guid" => $request->shipping_guid ?? null,
        ];
        $pickup = Pickup::create($pickUpData);
        return $pickup;
    }

    public function createOrderPickup($request, $pickup = null)
    {
        $orderPickup = OrderPickup::create([
            "pickup_id" => $request->pickup_id ?? optional($pickup)->id ?? null,
            "order_id" => $request->order_id,
            "shipping_id" => $request->shipping_id ?? null,
            "foreign_hawb" => $request->foreign_hawb ?? null,
            "shipment_url" => $request->shipment_url,
            "tracking_result" => $request->tracking_result,
            "shipping_method_id" => $request->shipping_method
        ]);
        Log::channel("shipping")->info($orderPickup);
        return $orderPickup;
    }

    public function getCredentials($method)
    {
        return config("shipping.{$method}");
    }

    private function client($url, $body)
    {
        // Execute the POST request
        try {
            // Create a new cURL resource
            $ch = curl_init($url);

            // Setup request to send json via POST
            $payload = json_encode($body);

            // Attach encoded JSON string to the POST fields
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

            // Set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'accept: application/json', 'cache-control: no-cache']);

            // Return response instead of outputting
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute the POST request
            $result = curl_exec($ch);

            // Close cURL resource
            curl_close($ch);

            return json_decode($result, true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
