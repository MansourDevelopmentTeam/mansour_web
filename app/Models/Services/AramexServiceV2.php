<?php

namespace App\Models\Services;

use Exception;
use Carbon\Carbon;
use App\Facade\Payment;
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

class AramexServiceV2 implements ShipmentsInterface
{

    private $accountNumber;
    private $userName;
    private $password;
    private $accountPin;
    private $accountEntity;
    private $accountCountryCode;
    private $url;

    public function __construct()
    {
        $this->url = config('integrations.aramex.url');
        $this->userName = config('integrations.aramex.username');
        $this->password = config('integrations.aramex.password');
        $this->accountNumber = config('integrations.aramex.sub_account.0.account_number');
        $this->accountPin = config('integrations.aramex.sub_account.0.account_pin');
        $this->accountEntity = config('integrations.aramex.account_entity');
        $this->accountCountryCode = config('integrations.aramex.account_country_code');

    }

    public function createShipment($order, $branch, $options = null)
    {
        $accountNumber = $options->aramex_account_number;
        if (!$accountNumber) {
            throw new Exception('Error Creating Shipment, details: aramex_account_number Required!');
        }

        $accountData = $this->aramexAccounts()[$accountNumber - 1];
        $this->accountNumber = $accountData['account_number'];
        $this->accountPin = $accountData['account_pin'];

        $branchProfile = $branch->delivererProfile;
        $branchCity = $branchProfile->area->aramex_area_name;
        $branchArea = isset($branchProfile->area->aramex_area_name) ? $branchProfile->area->aramex_area_name : '';
        $branchDistricts = isset($branchProfile->districts->name) ? $branchProfile->districts->name : '';
        $customer = $order->customer;
        $customerAddress = $order->address;
        $customerCity = $customerAddress->city->aramex_city_name;
        $customerArea = isset($customerAddress->area->aramex_area_name) ? $customerAddress->area->aramex_area_name : '';
        $customerDistricts = isset($customerAddress->district->name) ? $customerAddress->district->name : '';
        $orderWight = $order->order_wight;
        $orderNumberOfPisces = $order->order_number_of_pisces;
        $pickupParsedDate = Carbon::now()->addDay()->format('Y-m-d H:i:s');
        $Unix_Pickup_Date = strtotime($pickupParsedDate);
        $pickupDate = ($Unix_Pickup_Date.'000-0500');
        $data = [];

        [$totalAmount, $paymentService] = Payment::store($order->payment_method)->getAramexOrderTotal($order);

        try {
            $requestData['ClientInfo'] = [
                'UserName' => $this->userName,
                'Password' => $this->password,
                'Version' => 'v1.0',
                'AccountNumber' => $this->accountNumber,
                'AccountPin' => $this->accountPin,
                'AccountEntity' => $this->accountEntity,
                'AccountCountryCode' => $this->accountCountryCode,
            ];
            $requestData['LabelInfo'] = [
                'ReportID' => '9729',
                'ReportType' => 'URL',
            ];
            $requestData['Shipments'] = [
                [
                    'Shipper' => [
                        'Reference1' => $order->id, //opthional
                        'Reference2' => '', //opthional
                        'AccountNumber' => $this->accountNumber,
                        'PartyAddress' => [
                            'Line1' => 'Plot No. 2/6 S, Zone 6, 1st District, 5th Settlement',
                            'Line2' => $branchArea,
                            'Line3' => $branchDistricts,
                            'City' => $branchCity,
                            'StateOrProvinceCode' => '',
                            'PostCode' => '',
                            'CountryCode' => 'EG',
                        ],
                        'Contact' => [
                            'Department' => '',
                            'PersonName' => $branch->name, ////////////
                            'Title' => '',
                            'CompanyName' => config('app.name'), /////////
                            'PhoneNumber1' => config('app.hotline'), //$branch->phone,
                            'PhoneNumber1Ext' => '',
                            'PhoneNumber2' => '',
                            'PhoneNumber2Ext' => '',
                            'FaxNumber' => '',
                            'CellPhone' => $branch->phone,
                            'EmailAddress' => $branch->email,
                            'Type' => '',
                        ],
                    ],
                    'Consignee' => [
                        'Reference1' => '',
                        'Reference2' => '',
                        'AccountNumber' => '',
                        'PartyAddress' => [
                            'Line1' => $customerAddress->getAramexAddress(),
                            'Line2' => '',
                            'Line3' => '',
                            'City' => $customerArea,
                            'StateOrProvinceCode' => '',
                            'PostCode' => '',
                            'CountryCode' => 'EG',
                        ],
                        'Contact' => [
                            'Department' => '',
                            'PersonName' => $customer->name . ' ' . $customer->last_name, ////////////
                            'Title' => '',
                            'CompanyName' => $customer->name . ' ' . $customer->last_name, /////////
                            'PhoneNumber1' => $customer->phone,
                            'PhoneNumber1Ext' => '',
                            'PhoneNumber2' => '',
                            'PhoneNumber2Ext' => '',
                            'FaxNumber' => '',
                            'CellPhone' => $customer->phone,
                            'EmailAddress' => $customer->email,
                            'Type' => '',
                        ],
                    ],
                    'ThirdParty' => null,
                    'Reference1' => '',  //Any general detail the customer would like to add about the shipment
                    'Reference2' => '',  //Any general detail the customer would like to add about the shipment
                    'Reference3' => '',  //Any general detail the customer would like to add about the shipment
                    'ForeignHAWB' => "{$order->id}-" . time(), //Clientâ€™s shipment number if present.If filled this field must be unique for each shipment.
                    'TransportType' => 0,  //0 by Default  // 0 Or 1
                    'ShippingDateTime' => "/Date({$pickupDate})/",  //The date aramex receives the shipment to be shipped out.
                    'DueDate' => "/Date({$pickupDate})/", //The date specified for shipment to be delivered to the consignee.
                    'PickupLocation' => 'Reception', //The location from where the shipment should be picked up, such as the reception desk.
                    'PickupGUID' => $options->pickup_guid ?? '', //To add Shipments to existing pickups.
                    'Comments' => $options->shipping_notes ?? null, //Any comments on the shipment
                    'AccountingInstrcutions' => '', //Instructions on how to handle payment specifics.
                    'OperationsInstructions' => '', //Instructions on how to handle the shipment
                    'Details' => [
                        'Dimensions' => null,
                        'ChargeableWeight' => null,
                        'ActualWeight' => [
                            'Value' => $orderWight,
                            'Unit' => 'KG',
                        ],
                        'ProductGroup' => 'DOM',
                        'ProductType' => 'CDS',
                        'PaymentType' => 'P',
                        'PaymentOptions' => '',
                        'Services' => $paymentService,
                        'NumberOfPieces' => $orderNumberOfPisces,
                        'DescriptionOfGoods' => 'BOX',
                        'GoodsOriginCountry' => 'EG',
                        'CashOnDeliveryAmount' => [
                            'Value' => $totalAmount,
                            'CurrencyCode' => 'EGP',
                        ],
                        'InsuranceAmount' => null, //$order->invoice->grand_total,
                        'CollectAmount' => null,
                        'CashAdditionalAmount' => null,
                        'CashAdditionalAmountDescription' => '',
                        'CustomsValueAmount' => null,
                        'Items' => [
                        ],
                    ],
                ],
            ];
            foreach ($order->items as $item) {
                $product = $item->product;
                $requestData['Shipments'][0]['Details']['Items'][] = [
                    'PackageType' => 'Box',
                    'Quantity' => $item->amount,
                    'Weight' => [
                        'Value' => $product->weight,
                        'Unit' => 'Kg',
                    ],
                    'Comments' => $product->name,
                    'Reference' => '',
                ];
            }

            $response = $this->client('https://ws.aramex.net/shippingapi.v2/shipping/service_1_0.svc/json/CreateShipments', $requestData);

            Log::info($response);

            if (isset($response['HasErrors']) && false == $response['HasErrors']) {
                Storage::put('public/shipments/aramex-' . $response['Shipments'][0]['ForeignHAWB'] . '.pdf', file_get_contents($response['Shipments'][0]['ShipmentLabel']['LabelURL']));
                $pickup = null;
                if ($options->pickup_guid) {
                    $pickup = Pickup::where('shipping_guid', $options->pickup_guid)->first();
                }
                $orderPicupData = [
                    'pickup_id' => $pickup ? $pickup->id : null,
                    'order_id' => $order->id,
                    'shipping_id' => $response['Shipments'][0]['ID'],
                    'foreign_hawb' => $response['Shipments'][0]['ForeignHAWB'],
                    'shipment_url' => URL::to('') . Storage::url('shipments/aramex-' . $response['Shipments'][0]['ForeignHAWB'] . '.pdf'),
                ];

                return OrderPickup::create($orderPicupData);
                // $state = $this->getShipmentState($orderPickup->shipping_id);
                // $orderPickup->update(["update_description" => $state["UpdateDescription"], "status" => $state["UpdateCode"]]);
            }
            if (isset($response['Shipments'][0]['Notifications'][0]['Message'])) {
                throw new Exception($response['Shipments'][0]['Notifications'][0]['Message']);
            }

        }catch (Exception $exception){
            // $data = false;
            throw new Exception('Error Creating Shipment, details: '.$exception->getMessage());
            // return $data;
        }
    }

    public function createPickUp($orders, $options = null)
    {
        $accountNumber = $options->aramex_account_number;
        if (!$accountNumber) {
            throw new Exception('Error Creating Shipment, details: aramex_account_number Required!');
        }

        $this->aramex_account_number = $options->aramex_account_number;
        $this->branch_id = $options->branch_id;
        $this->shipping_notes = $options->shipping_notes;

        $accountData = $this->aramexAccounts()[$accountNumber - 1];
        $this->accountNumber = $accountData['account_number'];
        $this->accountPin = $accountData['account_pin'];

        $data = [];
        $this->branch = User::findOrFail($this->branch_id);
        $this->branch_profile = $this->branch->delivererProfile;

        $getShippingArea = ShippingAreas::getArea('ARAMEX', $this->branch_profile->area_id);

        $this->pickup_date_info = $options->pickup_date;
        $this->shipping_notes = $options->shipping_notes;

        $this->branch_city = $getShippingArea;
        $this->branch_area = isset($this->branch_profile->area->name) ? $this->branch_profile->area->name : '';
        $this->branch_districts = isset($this->branch_profile->districts->name) ? $this->branch_profile->districts->name : '';

        $this->pickup_date = (strtotime($this->pickup_date_info).'000-0500');
        $this->ready_time = strtotime($this->pickup_date_info);
        $this->closing_time = strtotime(Carbon::parse($this->pickup_date_info)->addHour());
        $this->last_pickup_time = strtotime(date(Carbon::parse($this->pickup_date_info)->addHours(3)));

        $shippingData = $this->shippingData($orders);

        $packageWeight = array_reduce($shippingData, function ($carry, $item) {
            $carry += $item['Details']['ActualWeight']['Value'];

            return $carry;
        });

        $itemCount = array_reduce($shippingData, function ($carry, $item) {
            $carry += $item['Details']['NumberOfPieces'];

            return $carry;
        });

        $request['ClientInfo'] = [
            'UserName' => $this->userName,
            'Password' => $this->password,
            'Version' => '1.0',
            'AccountNumber' => $this->accountNumber,
            'AccountPin' => $this->accountPin,
            'AccountEntity' => $this->accountEntity,
            'AccountCountryCode' => $this->accountCountryCode,
        ];

        $request['LabelInfo'] = [
            'ReportID' => '9729',
            'ReportType' => 'URL',
        ];

        $request['Transaction'] = [
            'Reference1' => '',
            'Reference2' => '',
            'Reference3' => '',
            'Reference4' => '',
            'Reference5' => '',
        ];
        $request['Pickup'] = [
            'PickupLocation' => "{$this->branch_city}  / {$this->branch_area} /  {$this->branch_districts} ",
            'PickupDate' => "/Date({$this->pickup_date})/",
            'ReadyTime' => "/Date({$this->ready_time})/",
            'LastPickupTime' => "/Date({$this->last_pickup_time})/",
            'ClosingTime' => "/Date({$this->closing_time})/",
            'Comments' => '',
            'Reference1' => '001',
            'Reference2' => '',
            'Vehicle' => '',
            'Status' => 'Ready',
            'PickupItems' => [
                [
                    'ProductGroup' => 'DOM',
                    'ProductType' => 'CDS',
                    'NumberOfShipments' => count($orders),
                    'PackageType' => 'Box',
                    'Payment' => 'p',
                    'ShipmentVolume' => null,
                    'NumberOfPieces' => $itemCount,
                    'CashAmount' => null,
                    'ExtraCharges' => null,
                    'Comments' => $this->shipping_notes,
                    'ShipmentDimensions' => [
                        'Length' => 0,
                        'Width' => 0,
                        'Height' => 0,
                        'Unit' => 'cm',
                    ],
                    'ShipmentWeight' => [
                        'Unit' => 'KG',
                        'Value' => $packageWeight,
                    ],
                ],
            ],
            'PickupAddress' => [
                'Line1' => "{$this->branch_city}  / {$this->branch_area} /  {$this->branch_districts} ",
                'Line2' => '',
                'Line3' => '',
                'City' => $this->branch_city,
                'StateOrProvinceCode' => '',
                'PostCode' => '',
                'CountryCode' => 'EG',
                'Longitude' => 0,
                'Latitude' => 0,
                'BuildingNumber' => null,
                'BuildingName' => null,
                'Floor' => null,
                'Apartment' => null,
                'POBox' => null,
                'Description' => null,
            ],
            'PickupContact' => [
                'Department' => '',
                'PersonName' => $this->branch->name,
                'Title' => '',
                'CompanyName' => config('app.name'),
                'PhoneNumber1' => $this->branch->phone,
                'PhoneNumber1Ext' => '',
                'PhoneNumber2' => '',
                'PhoneNumber2Ext' => '',
                'FaxNumber' => '',
                'CellPhone' => $this->branch->phone,
                'EmailAddress' => $this->branch->email,
                'Type' => '',
            ],
        ];
        $request['Pickup']['Shipments'] = $shippingData;

        // API URL
        Log::info(json_encode($request));

        $response = $this->client('https://ws.aramex.net/ShippingAPI.V2/Shipping/Service_1_0.svc/json/CreatePickup', $request);

        Log::info($response);

        if (isset($response['HasErrors']) && false == $response['HasErrors'] && isset($response['ProcessedPickup']['ProcessedShipments'][0]['HasErrors']) && false == $response['ProcessedPickup']['ProcessedShipments'][0]['HasErrors'] && isset($response['ProcessedPickup'], $response['ProcessedPickup']['ProcessedShipments']) && is_array($response['ProcessedPickup']['ProcessedShipments'])) {
            $pickUpData = [
                'shipping_method' => 3,
                'notes' => $this->shipping_notes,
                'pickup_time' => $this->pickup_date,
                'status' => 1,
                'shipping_id' => $response['ProcessedPickup']['ID'],
                'shipping_guid' => $response['ProcessedPickup']['GUID'],
            ];
            $pickup = Pickup::create($pickUpData);
            foreach ($response['ProcessedPickup']['ProcessedShipments'] as $shipment) {
                if (isset($shipment['HasErrors']) && false == $shipment['HasErrors']) {
                    Storage::put('public/shipments/aramex-'.$shipment['ForeignHAWB'].'.pdf', file_get_contents($shipment['ShipmentLabel']['LabelURL']));

                    $orderPicupData = [
                        'pickup_id' => $pickup->id,
                        'order_id' => $shipment['ForeignHAWB'],
                        'shipping_id' => $shipment['ID'],
                        'foreign_hawb' => $shipment['ForeignHAWB'],
                        'shipment_url' => URL::to('').Storage::url('shipments/aramex-'.$shipment['ForeignHAWB'].'.pdf'),
                    ];

                    $orderPicup = OrderPickup::create($orderPicupData);
                    // $state = $this->getShipmentState($orderPicup->shipping_id);
                    // $orderPicup->update(["update_description" => $state["UpdateDescription"], "status" => $state["UpdateCode"]]);
                    // try {
                    //     $TrackingData = Aramex::trackShipments(["$orderPicup->shipping_id"]);

                    //     if (!$TrackingData->HasErrors) {
                    //         Log::info("TRACKING DATA: ", ["td" => $TrackingData]);
                    //         $trackingResult = $TrackingData->TrackingResults->KeyValueOfstringArrayOfTrackingResultmFAkxlpY->Value->TrackingResult;
                    //         if (is_array($trackingResult)) {
                    //             $lastUpdateCode = $trackingResult[0]->UpdateCode;
                    //             $lastTrackingUpdate = $trackingResult[0]->UpdateDescription;
                    //         }else {
                    //             $lastUpdateCode = $trackingResult->UpdateCode;
                    //             $lastTrackingUpdate = $trackingResult->UpdateDescription;
                    //             $trackingResult = [$trackingResult];
                    //         }
                    //         $orderPicup->update(['update_description'=>$lastTrackingUpdate,'tracking_result'=>$trackingResult,'status'=>$lastUpdateCode]);
                    //     }
                    // }catch (\Exception $e) {

                    //     Log::error($e->getMessage());
                    // }
                } else {
                    $data[] = $shipment['Notifications'][0]['Message'];
                }
            }

            if (empty($data)) {
                return true;
            }

            return $data;
        }

        if (isset($response['ProcessedPickup']['ProcessedShipments'][0]['Notifications'][0]['Message'])) {
            $data[] = $response['ProcessedPickup']['ProcessedShipments'][0]['Notifications'][0]['Message'];
        } elseif (isset($response['Notifications'][0])) {
            $data[] = $response['Notifications'][0]['Message'];
        } else {
            $data = false;
        }

        return $data;
    }

    public function getDeliveryFees($address, $cart)
    {

        $weight = 0;
        $numberOfPiece = 0;
        foreach ($cart->cartItems as $item) {
            $product = Product::findOrFail($item['product_id']);
            $weight += $product->weight * $item['amount'];
            $numberOfPiece += $item['amount'];
        }

        $getShippingArea = ShippingAreas::getArea('ARAMEX', $address->area->id);
        if ($getShippingArea != '') {
            return false;
        }

        $city = $getShippingArea;
        $branch = User::findOrFail(1015315);
        $originCity = $branch->addresses[0]->area->aramex_area_name;
        $originAddress = [
            'line1' => '',
            'city' => $originCity,
            'country_code' => 'EG',
        ];
        $destinationAddress = [
            'line1' => '',
            'city' => $city,
            'country_code' => 'EG',
        ];
        // $shipmentDetails = [
        //     'weight' => 5, // KG
        //     'number_of_pieces' => 2,
        //     'payment_type' => 'P', // if u don't pass it, it will take the config default value
        //     'product_group' => 'EXP', // if u don't pass it, it will take the config default value
        //     'product_type' => 'PPX', // if u don't pass it, it will take the config default value
        //     'height' => 5.5, // CM
        //     'width' => 3,  // CM
        //     'length' => 2.3  // CM
        // ];
        $shipmentDetails = [
            'weight' => $weight, // KG
            'number_of_pieces' => $numberOfPiece,
        ];
        $currency = 'EGP';

        try {
            Log::info('Calculate Rate Aramex', ['originAddress' => $originAddress, 'destinationAddress' => $destinationAddress, 'shipmentDetails' => $shipmentDetails, 'currency' => $currency]);
            $data = Aramex::calculateRate($originAddress, $destinationAddress, $shipmentDetails, $currency);
            if (!$data->HasErrors) {
                return $data->TotalAmount->Value;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function checkShipmentStatus($shipmentId)
    {
        $shipmentId = !is_array($shipmentId) ? [$shipmentId] : $shipmentId;

        $request = [
            'ClientInfo' => [
                'UserName' => $this->userName,
                'Password' => $this->password,
                'Version' => 'v1.0',
                'AccountNumber' => $this->accountNumber,
                'AccountPin' => $this->accountPin,
                'AccountEntity' => $this->accountEntity,
                'AccountCountryCode' => $this->accountCountryCode,
                'Source' => 24,
            ],
            'GetLastTrackingUpdateOnly' => true,
            'Shipments' => $shipmentId,
            'Transaction' => [
                'Reference1' => '',
                'Reference2' => '',
                'Reference3' => '',
                'Reference4' => '',
                'Reference5' => '',
            ],
        ];

        $response = $this->client($this->url . '/Tracking/Service_1_0.svc/json/TrackShipments', $request);

        Log::info('Track Response: ', ['tr' => $response]);

        if ($response['HasErrors']) {
            return $response['Notifications'][0]['Message'];
        }

        return $response['TrackingResults'][0]['Value'][0];
    }

    public function cancelPickup($pickup)
    {

    }

    public static function aramexAccounts()
    {
        return config('integrations.aramex.sub_account');
    }

    public function shippingData($orders)
    {
        $data = [];

        foreach ($orders as $order) {

            [$totalAmount, $paymentService] = Payment::store($order->payment_method)->getAramexOrderTotal($order);

            $item_count = $order->items->reduce(function ($carry, $item) {
                return $carry + $item->amount;
            });

            $shippmentWeight = $order->items->reduce(function ($carry, $item) {
                return $carry + ($item->product->weight * $item->amount);
            });

            $customer = $order->customer;
            $customerAddress = $order->address;
            $customerCity = $customerAddress->area->aramex_area_name;
            $customerArea = isset($customerAddress->area->name) ? $customerAddress->area->name : '';
            $customerDistricts = isset($customerAddress->district->name) ? $customerAddress->district->name : '';
            $shipmentData = [
                'Shipper' => [
                    'Reference1' => $order->id, //opthional
                    'Reference2' => '', //opthional
                    'AccountNumber' => $this->accountNumber,
                    'PartyAddress' => [
                        'Line1' => 'Plot No. 2/6 S, Zone 6, 1st District, 5th Settlement', //$branchCity,//
                        'Line2' => $this->branch_city,
                        'Line3' => $this->branch_districts,
                        'City' => $this->branch_city,
                        'StateOrProvinceCode' => '',
                        'PostCode' => '',
                        'CountryCode' => 'EG',
                    ],
                    'Contact' => [
                        'Department' => '',
                        'PersonName' => $this->branch->name, ////////////
                        'Title' => '',
                        'CompanyName' => config('app.name'), /////////
                        'PhoneNumber1' => config('app.hotline'), //$branch->phone,
                        'PhoneNumber1Ext' => '',
                        'PhoneNumber2' => '',
                        'PhoneNumber2Ext' => '',
                        'FaxNumber' => '',
                        'CellPhone' => $this->branch->phone,
                        'EmailAddress' => $this->branch->email,
                        'Type' => '',
                    ],
                ],
                'Consignee' => [
                    'Reference1' => '',
                    'Reference2' => '',
                    'AccountNumber' => '',
                    'PartyAddress' => [
                        'Line1' => $customerAddress->getAramexAddress(),
                        'Line2' => $customerArea,
                        'Line3' => $customerDistricts,
                        'City' => $customerCity,
                        'StateOrProvinceCode' => '',
                        'PostCode' => '',
                        'CountryCode' => 'EG',
                    ],
                    'Contact' => [
                        'Department' => '',
                        'PersonName' => $customer->name . ' ' . $customer->last_name, ////////////
                        'Title' => '',
                        'CompanyName' => $customer->name . ' ' . $customer->last_name, /////////
                        'PhoneNumber1' => $customer->phone,
                        'PhoneNumber1Ext' => '',
                        'PhoneNumber2' => '',
                        'PhoneNumber2Ext' => '',
                        'FaxNumber' => '',
                        'CellPhone' => $customer->phone,
                        'EmailAddress' => $customer->email,
                        'Type' => '',
                    ],
                ],
                'ThirdParty' => null,
                'Reference1' => '',  //Any general detail the customer would like to add about the shipment
                'Reference2' => '',  //Any general detail the customer would like to add about the shipment
                'Reference3' => '',  //Any general detail the customer would like to add about the shipment
                'ForeignHAWB' => "{$order->id}-".time(), //Clientâ€™s shipment number if present.If filled this field must be unique for each shipment.
                'TransportType' => 0,  //0 by Default  // 0 Or 1
                'ShippingDateTime' => "/Date({$this->pickup_date})/",  //The date aramex receives the shipment to be shipped out.
                'DueDate' => "/Date({$this->pickup_date})/", //The date specified for shipment to be delivered to the consignee.
                'PickupLocation' => 'Reception', //The location from where the shipment should be picked up, such as the reception desk.
                'PickupGUID' => '', //To add Shipments to existing pickups.
                'Comments' => $this->shipping_notes, //Any comments on the shipment
                'AccountingInstructions' => '', //Instructions on how to handle payment specifics.
                'OperationsInstructions' => '', //Instructions on how to handle the shipment
                'Details' => [
                    'Dimensions' => null,
                    'ChargeableWeight' => null,
                    'ActualWeight' => [
                        'Value' => $shippmentWeight,
                        'Unit' => 'KG',
                    ],
                    'ProductGroup' => 'DOM',
                    'ProductType' => 'CDS',
                    // 'PaymentType' => $paymentType,
                    'PaymentType' => 'P',
                    'PaymentOptions' => '',
                    // 'Services' => $paymentService,
                    'NumberOfPieces' => $item_count,
                    'DescriptionOfGoods' => 'BOX',
                    'GoodsOriginCountry' => 'EG',
                    'CashOnDeliveryAmount' => [
                        'Value' => $totalAmount,
                        'CurrencyCode' => 'EGP',
                    ],
                    'InsuranceAmount' => null, // $order->invoice->grand_total,
                    'CollectAmount' => null,
                    'CashAdditionalAmount' => null,
                    'CashAdditionalAmountDescription' => '',
                    'CustomsValueAmount' => null,
                    'Items' => [
                    ],
                ],
            ];

            if ('CODS' == $paymentService) {
                $shipmentData['Details']['Services'] = 'CODS';
            }

            $data[] = $shipmentData;
        }

        return $data;
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

    public function validateAddress($address)
    {
        if (!isset($address->area->aramex_area_name) || null == $address->area->aramex_area_name) {
            return false;
        }
        $city = $address->area->aramex_area_name;

        try {
            $validateAddress = Aramex::validateAddress([
                'line1' => '', // optional (Passing it is recommended)
                'line2' => '', // optional
                'line3' => '', // optional
                'country_code' => 'EG',
                'postal_code' => '', // optional
                'city' => $city,
            ]);
            Log::info(json_encode($validateAddress));
            if ($validateAddress->HasErrors) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::info("Aramex service failed in validate address " . $e->getMessage());
            return false;
        }
    }
}