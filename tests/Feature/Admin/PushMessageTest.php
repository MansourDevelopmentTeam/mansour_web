<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\Users\User;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Notifications\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PushMessageTest extends TestCase
{
    use RefreshDatabase;

    /**  @test */
    public function test_can_push_message_general_notification()
    {
        // $this->withoutExceptionHandling();

        $user = User::find(1);
        $customer = factory(User::class)->create();

        $data = [
            "title" => "title of the message",
            "body" =>"body of the message",
            "customer_id" => $customer->id,
            "image"  => config('app.url') . "/storage/uploads/TBXAqL-1620731607.jpg"
        ];

        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        $response = $this->actingAs($user)->post("api/admin/push_messages", $data);

        $notification = Notification::where('user_id', $customer->id)->first();

        $result = $response->json();

        $this->assertTrue(Arr::has($result, 'data.id'));

        
        $this->assertEquals(200, $result['code']);
        $this->assertEquals(1, $notification->count());
        $this->assertEquals(Notification::TYPE_GENERAL, $notification->type);
    } 

    /** @test */
    public function test_can_push_message_type_product_notification()
    {
        // $this->withoutExceptionHandling();

        $user = User::find(1);
        $customer = factory(User::class)->create();

        $data = [
            "title" => "title of the message",
            "body" =>"body of the message",
            "product_id" => 1,
            "customer_id" => $customer->id,
            "image"  => config('app.url') . "/storage/uploads/TBXAqL-1620731607.jpg"
        ];

        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        $response = $this->actingAs($user)->post("api/admin/push_messages", $data);

        $notification = Notification::where('user_id', $customer->id)->first();

        $result = $response->json();

        $this->assertTrue(Arr::has($result, 'data.id'));

        
        $this->assertEquals(200, $result['code']);
        $this->assertEquals(1, $notification->count());
        $this->assertEquals(Notification::TYPE_PRODUCT, $notification->type);
    } 
}
