<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Users\User;
use Illuminate\Support\Arr;
use App\Models\Products\Tag;
use App\Mail\StockNotifications;
use App\Models\Products\Product;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Products\ProductTag;
use Illuminate\Support\Facades\Mail;
use App\Models\Products\StockNotification;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductVariantTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function test_can_send_email_when_product_has_stock()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $user = factory(User::class)->create();

        $mainProduct = factory(Product::class)->create();
        $vairantProduct = factory(Product::class)->create(['parent_id' => $mainProduct->id, 'stock' => 0]);
        factory(ProductTag::class)->create(['product_id' => $vairantProduct->id]);

        $data = $this->getData();

        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        $email = 'esmail@el-dokan.com';

        StockNotification::create(['product_id' => $vairantProduct->id, "email" => $email]);

        $response = $this->actingAs($user)->put("api/admin/products/{$mainProduct->id}/variants/{$vairantProduct->id}", $data);
        // $result = $response->json();

        // dd($result);

        // Assert a message was sent to the given users...
        Mail::assertQueued(StockNotifications::class, function ($mail) use ($email) {
            return $mail->hasTo($email);
        });

        // Assert a mailable was sent twice...
        Mail::assertQueued(StockNotifications::class, 1);
    } 

    private function getData()
    {
        return [
            "name" => $this->faker->name,
            "name_ar" => $this->faker->name,
            'description' => $this->faker->text,
            'description_ar' => $this->faker->text,
            "image" => $this->faker->imageUrl(),
            "sku" => "SM-A715FZKGEGY",
            "stock" => 1
        ];
    }

}
