<?php

namespace Tests\Feature\Customer;

use Mockery;
use Tests\TestCase;
use App\Models\Users\User;
use App\Mail\NewRegistration;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    /** @test */
    public function test_can_register_customer()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        //User's data
        $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234',
            'phone' => '01097072480'
        ];
        //Send post request
        $response = $this->json('POST','/api/customer/auth/signup',$data);
        $result = $response->json();

        //Assert it was successful
        $this->assertEquals(200, $result['code']);

        //Assert we received a token
        $this->assertArrayHasKey('data',$response->json());

        Mail::assertSent(NewRegistration::class, 1);
    }

    /** @test */
    public function test_can_register_customer_with_verified_phone()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        //User's data
        $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234',
            'phone' => '01097072480'
        ];
        //Send post request
        $response = $this->json('POST','/api/customer/auth/signup',$data);

        $result = $response->json();

        $user = User::where('email', $data['email'])->first();

        $this->assertEquals(200, $result['code']);
        $this->assertCount(2, User::all());
        $this->assertEquals(1, $user->phone_verified);
        $this->assertArrayHasKey('data',$result);
        
    }

    /** @test */
    public function test_can_register_name_required()
    {

        $data = [
            'email' => 'test@gmail.com',
            // 'name' => 'Test',
            'password' => 'secret1234'
        ];

        //Send post request
        $response = $this->json('POST','/api/customer/auth/signup',$data);
        $results = $response->json();

        $this->assertArrayHasKey('code', $results);
        $this->assertEquals($results['code'], 422);
        $user = User::where('email','test@gmail.com')->get();
        $this->assertCount(0, $user);

    }

    /** @test */
    public function test_can_register_email_required()
    {

        $data = [
            // 'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234'
        ];

        //Send post request
        $response = $this->json('POST','/api/customer/auth/signup',$data);
        $results = $response->json();

        $this->assertArrayHasKey('code', $results);
        $this->assertEquals($results['code'], 422);
        $user = User::where('email','test@gmail.com')->get();
        $this->assertCount(0, $user);

    }
    /** @test */
    public function testEmailSentWhenCustomerRegister()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        // Perform register customer
        $data = [
            'email' => 'test@gmail.com',
            'name' => 'Test',
            'password' => 'secret1234'
        ];
        //Send post request
        $response = $this->json('POST','/api/customer/auth/signup',$data);
        
        // Assert that no mailables were sent...
        // Mail::assertNothingSent();

        // Assert that a mailable was sent...
        Mail::assertSent(NewRegistration::class, 1);
    }

    // public function test_socialite_google_login() 
    // {
    //     $this->withoutExceptionHandling();

    //     $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');

    //     $abstractUser
    //             ->shouldReceive('getId')
    //             ->andReturn(rand())
    //             ->shouldReceive('getNickName')
    //             ->andReturn(uniqid())
    //             ->shouldReceive('getName')
    //             ->andReturn(uniqid())
    //             ->shouldReceive('getEmail')
    //             ->andReturn(uniqid() . '@gmail.com')
    //             ->shouldReceive('getAvatar')
    //             ->andReturn('https://en.gravatar.com/userimage');

    //     $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        

    //     $provider->shouldReceive('user')
    //             ->andReturn($abstractUser);
                
    //     Socialite::shouldReceive('driver')
    //         ->with('google')
    //         ->andReturn($provider)
    //         ->shouldReceive('stateless')
    //         ->once();

    //     //Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

    //     $response = $this->post('api/customer/auth/social', ['provider' => 'google']);
                
    //     dd($response->json());
        
    //     $response->assertStatus(302)
    //                 ->assertRedirect(route('home'));

    // }


}
