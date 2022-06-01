<?php

namespace App\Classes\Payment;

use App\Classes\Payment\Methods\CodMethod;
use App\Contracts\PaymentMethod;
use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;
use Illuminate\Support\Manager;

class PaymentManager extends Manager
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The array of resolved payment stores.
     *
     * @var array
     */
    protected $stores = [];

    /**
     * Create a new payment manager instance.
     *
     * @param  Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * Get a payment store instance by name, wrapped in a repository.
     *
     * @param null  $name
     */
    public function store(int $name = null)
    {
        $name = $name ?: $this->getDefaultDriver();

        return $this->stores[$name] = $this->get($name);
    }

    /**
     * Attempt to get the store from the local payment.
     *
     * @param  $name
     * @return mixed
     */
    protected function get($name)
    {
        return $this->stores[$name] ?? $this->resolve($name);
    }

    /**
     * Resolve the given store.
     *
     * @param  $name
     *
     * @return mixed
     */
    protected function resolve($name)
    {
        $config = $this->getConfig($name);

        if (is_null($config)) {
            throw new InvalidArgumentException("Payment store [{$name}] is not defined.");
        }

        try {

            $driverCLass = $config['class'];
            return new $driverCLass($config);

        } catch (\Exception $e) {
            // dd($e);
            throw new InvalidArgumentException("Driver [{$config['driver']}] is not supported.");
        }
    }

    /**
     * Get the payment connection configuration.
     *
     * @param  $name
     * @return array
     */
    protected function getConfig($name): array
    {
        return $this->app['config']["payment.stores.{$name}"];
    }
    /**
     * Get the default payment driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->app['config']['payment.driver'];
    }

}
