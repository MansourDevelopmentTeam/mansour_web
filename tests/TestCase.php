<?php

namespace Tests;

use App\Models\Users\User;
use Faker\Factory as Faker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase
 * @package Tests
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    // , DatabaseMigrations, DatabaseTransactions;

    protected $faker;


    /**
     * Set up the test
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    /**
     * Reset the migrations
     */
    public function tearDown(): void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }

    protected function actingAsCustomer($user = null)
    {
        $user = $user ?: create(User::class);

        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        return $this;
    }

    protected function actingAsAdmin()
    {
        $admin = User::find(1);

        $token = JWTAuth::fromUser($admin);
        $this->withHeader('Authorization', 'Bearer ' . $token);

        return $this;
    }
}
