<?php

namespace Tests\Feature;

use App\Classes\Shipping\ShippingFactory;
use App\Models\Branch\Branch;
use App\Models\Orders\Order;
use App\Models\Shipping\ShippingMethods;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShippingTest extends TestCase
{
    //use DatabaseMigrations;

    public function test_aramex()
    {
        $shippingFactory = new ShippingFactory();
        $response = $shippingFactory::make(ShippingMethods::ARAMEX);

        //$checkShipmentStatus = $response->checkShipmentStatus(1);

        $order = factory(Order::class)->create();
        dd("d");
        $branch = factory(Branch::class)->create();

        $options = new \stdClass();
        $options->aramex_account_number = 1;
        $options->pickup_guid = 1;
        $options->shipping_notes = 'test';

        $createShipment = $response->createShipment($order, $branch, $options);
        dd($createShipment);

        $response->assertStatus(200);
    }

    public function test_bosta_shipment_status()
    {
        $shippingFactory = new ShippingFactory();
        $response = $shippingFactory::make(ShippingMethods::BOSTA);

        $getShipmentState = $response->checkShipmentStatus(27307);
        dd($getShipmentState);

        $response->assertStatus(200);
    }
}
