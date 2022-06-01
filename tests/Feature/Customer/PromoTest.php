<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\Users\User;
use Illuminate\Support\Arr;
use App\Models\Payment\Promo;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PromoTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function test_can_apply_promo_with_customer_not_have_phone()
    {
        $this->withoutExceptionHandling();

        $customer = create(User::class, ['phone' => null]);
        $promo = create(Promo::class);

        $this->actingAsCustomer($customer);

        $data = [
            'promo' => $promo->name
        ];

        $response = $this->post(route('order.checkPromo'), $data);
        $result = $response->json();

        $this->assertEquals("please verify your phone", Arr::get($result, 'message'));
    }

    /** @test */
    public function test_can_apply_promo_with_customer_phone_not_verified_first_time()
    {
        Event::fake();
        
        $this->withoutExceptionHandling();

        $customer = create(User::class, ['phone' => '201097072480', 'phone_verified' => 0]);
        $promo = create(Promo::class);

        $this->actingAsCustomer($customer);

        $data = [
            'promo' => $promo->name
        ];

        $response = $this->post(route('order.checkPromo'), $data);
        $result = $response->json();

        //TODO: Refactor this event with sms service
        // Event::assertDispatched(PhoneVerificationEvent::class);

        $this->assertEquals("please verify your phone", Arr::get($result, 'message'));
    }

    /** @test */
    public function test_can_apply_promo_with_customer_phone_not_verified_and_incorrect_code()
    {
        Event::fake();
        
        $this->withoutExceptionHandling();

        $code = rand(1000, 9999);
        $customer = create(User::class, ['phone' => '201097072480', 'phone_verified' => 0, 'verification_code' => $code]);
        $promo = create(Promo::class);

        $this->actingAsCustomer($customer);

        $data = [
            'promo' => $promo->name,
            'verification_code' => 1234
        ];

        $response = $this->post(route('order.checkPromo'), $data);
        $result = $response->json();

        //TODO: Refactor this event with sms service
        // Event::assertNotDispatched(PhoneVerificationEvent::class);

        $this->assertEquals("Incorrect Verification Code!", Arr::get($result, 'message'));
    }

    /** @test */
    public function test_can_apply_promo_with_customer_with_verified_code()
    {
        $this->withoutExceptionHandling();

        $code = rand(1000, 9999);
        $customer = create(User::class, ['phone' => '201097072480', 'phone_verified' => 0, 'verification_code' => $code]);
        $promo = create(Promo::class);

        $this->actingAsCustomer($customer);

        $data = [
            'promo' => $promo->name,
            'verification_code' => $code
        ];
        $response = $this->post(route('order.checkPromo'), $data);

        $this->assertEquals(1, User::find($customer->id)->phone_verified);
        $this->assertEquals(null, User::find($customer->id)->verification_code);
    }
}
