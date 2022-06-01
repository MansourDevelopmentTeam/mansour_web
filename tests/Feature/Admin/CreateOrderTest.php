<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Users\User;
use Illuminate\Support\Arr;
use App\Models\Users\Address;
use App\Models\Products\Product;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Payment\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_order_with_product_out_of_stock()
    {
        $admin = User::find(1);

        $token = JWTAuth::fromUser($admin);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        $data = $this->getData();

        $response = $this->post(route('admin.order.store'), $data);
        $result = $response->json();

        $product = Product::find(2);

        $this->assertEquals(422, $result['code']);
        $this->assertEquals("Product {$product->name} is out of stock", Arr::get($result, 'errors.errorDetails.stock_available.0'));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_order_with_product_stock_less_amount_requested()
    {
        $admin = User::find(1);

        $token = JWTAuth::fromUser($admin);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        $data = $this->getData();
        $data['items'][0] = [
            "id" => factory(Product::class)->create(['parent_id' => 1, 'stock' => 1])->id,
            "amount" => 10
        ];

        $response = $this->post(route('admin.order.store'), $data);
        $result = $response->json();

        $product = Product::find(3);

        $this->assertEquals(422, $result['code']);
        $this->assertEquals("Product {$product->name} is only {$product->stock} available", Arr::get($result, 'errors.errorDetails.stock_available.0'));
    }

    private function getData()
    {
        $user = factory(User::class)->create();
        $payment_method = factory(PaymentMethod::class)->create();
        $mainProduct = factory(Product::class)->create();
        $address = factory(Address::class)->create();

        return [
            'payment_method' => $payment_method->id,
            'address_id' => $address->id,
            'user_id' => $user->id,
            'items' => [[
                "id" => factory(Product::class)->create(['parent_id' => $mainProduct->id, 'stock' => 0])->id,
                "amount" => 1
            ]],
 
        ];
    }
}
