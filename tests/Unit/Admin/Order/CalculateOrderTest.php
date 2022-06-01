<?php

namespace Tests\Unit\Admin\Order;

use Tests\TestCase;
use App\Models\Users\User;
use Illuminate\Support\Arr;
use App\Models\Payment\Invoice;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Orders\OrderProduct;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CalculateOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_can_add_discount_to_product_in_order()
    {
        // $this->withoutExceptionHandling();

        $admin = User::find(1);

        $order = factory(OrderProduct::class)->create();
        $invoice = factory(Invoice::class)->create(['order_id' => $order->order_id]);

        $data = [
            "discount_price" => 0
        ];

        $token = JWTAuth::fromUser($admin);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        $response = $this->post(route('order.update.item.price', ['id' => $order->order_id, 'product_id' => $order->product_id ]), $data);
        $result = $response->json();

        $this->assertEquals($result['code'], 422);
        $this->assertEquals("The discount price must be greater than 0.", Arr::get($result, 'errors.errorDetails.discount_price.0'));
    }
}
