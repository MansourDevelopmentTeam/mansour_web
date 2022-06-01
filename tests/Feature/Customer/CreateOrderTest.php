<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use Tests\AttachesJWT;
use App\Models\Users\User;
use App\Models\Orders\Cart;
use Illuminate\Support\Arr;
use App\Models\Users\Address;
use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Orders\CartItem;
use App\Models\Products\Product;
use App\Models\Locations\District;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment\PaymentMethod;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_can_create_an_order()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create();
        $payment_method = factory(PaymentMethod::class)->create();
        $mainProduct = factory(Product::class)->create();

        factory(Cart::class)->create(['user_id' => $user->id])
            ->each(function ($cart) use($mainProduct) {
                factory(CartItem::class)->create(['cart_id' => $cart->id, 'product_id' => factory(Product::class)->create(['parent_id' => $mainProduct->id])->id]);
                factory(CartItem::class)->create(['cart_id' => $cart->id, 'product_id' => factory(Product::class)->create(['parent_id' => $mainProduct->id])->id]);
            });

        $address = factory(Address::class)->create();

        $data = [
            'payment_method' => $payment_method->id,
            'address_id' => $address->id,
            'device_type' => 1
        ];

        $token = JWTAuth::fromUser($user);
        // dd($user);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        $response = $this->actingAs($user)->post("api/customer/orders", $data);

        $response->assertStatus(200);

        $response->assertJsonStructure(array_keys($data), $data);
    }
}
