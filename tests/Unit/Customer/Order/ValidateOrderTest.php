<?php

namespace Tests\Unit\Customer\Order;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Users\User;
use Illuminate\Support\Arr;
use App\Models\Orders\Order;
use App\Models\Products\Product;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Services\OrdersService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ValidateOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @var OrdersService $ordersService */
    private $ordersService;

    public function setUp(): void
    {
        parent::setUp();
        $this->ordersService = $this->app->make('App\Models\Services\OrdersService');
    }

    /**  @test */
    public function test_customer_can_buy_items_has_max_per_order_first_time()
    {
        // $this->withoutExceptionHandling();

        $customer = factory(User::class)->create();
        $products = factory(Product::class, 2)->create([
            'max_per_order' => $this->faker->numberBetween(5, 10),
            // 'max_per_order' => null,
            // 'min_days' => 1,
            'parent_id' => factory(Product::class)->create()->id
        ]);

        $order = factory(Order::class)->create([
            'user_id' => $customer->id,
            // 'created_at' => Carbon::now()->subDays(2)
        ]);
        $amount = $this->faker->numberBetween(1, 5);
        $orderProducts = array_fill_keys($products->pluck('id')->toArray(), ['amount' => $amount]);
        $order->products()->sync($orderProducts);

        foreach ($products as $key => $product) {
            $product->amount = $this->faker->numberBetween(1,5);
        }
        $this->be($customer);

        $max_per_order = $products->first()->max_per_order;

        $this->ordersService->customerCanBuyItems($products);

        $max_per_order_filtered = $products->first()->max_per_order;

        $this->assertEquals($max_per_order_filtered, $max_per_order);
    } 
    
}
