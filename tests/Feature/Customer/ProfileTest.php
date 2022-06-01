<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\Users\User;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_change_password_with_exists_wrong_password_english_message()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(['password' => bcrypt(12345678)]);

        $data = [
            "old_password" => "123456",
            "password" => "123456789"
        ];

        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', 'Bearer ' . $token);
        $response = $this->post("api/customer/profile/change_password", $data);
        $result = $response->json();

        $this->assertEquals(403, $result['code']);
        $this->assertEquals("Incorrect password, kindly check them again.", $result['message']);
    }
    public function test_can_change_password_with_exists_wrong_password_arabic_message()
    {
        $this->withoutExceptionHandling();

        $user = factory(User::class)->create(['password' => bcrypt(12345678)]);

        $data = [
            "old_password" => "123456",
            "password" => "123456789"
        ];

        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', 'Bearer ' . $token);
        $this->withHeader('lang', 2);
        $response = $this->post("api/customer/profile/change_password", $data);

        $result = $response->json();

        $this->assertEquals(403, $result['code']);
        $this->assertEquals("يوجد خطأ بكلمة المرور , رجاءا اعد المحاولة", $result['message']);
    }
}
