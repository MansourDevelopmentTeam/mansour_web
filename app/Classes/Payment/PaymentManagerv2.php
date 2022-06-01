<?php

namespace App\Classes\Payment;

use InvalidArgumentException;
use Illuminate\Support\Manager;
use App\Contracts\PaymentMethod;
use Illuminate\Cache\CacheManager;
use App\Classes\Payment\Methods\CodMethod;
use App\Models\Repositories\PaymentRepository;
use Illuminate\Contracts\Foundation\Application;

class PaymentManagerv2 extends Manager
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /** @var \Illuminate\Database\Eloquent\Collection */
    protected $methods;

    /**
     * The array of resolved payment stores.
     *
     * @var array
     */
    protected $stores = [];

    /**
     * Create a new payment manager instance.
     *
     * @param CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager)
    {
        dd($cacheManager->store());
    }

    /**
     * Get a payment store instance by id, wrapped in a repository.
     *
     * @param int|null  $id
     */
    public function store(int $id = null)
    {
        return $this->stores[$id] = $this->get($id);
    }

    /**
     * Attempt to get the store from the local payment.
     *
     * @param  $id
     * @return mixed
     */
    protected function get($id)
    {
        return $this->stores[$id] ?? $this->resolve($id);
    }

    /**
     * Resolve the given store.
     *
     * @param  $name
     *
     * @return mixed
     */
    protected function resolve($method_id)
    {
        $provider = $this->getProvider($method_id);

        if (empty($provider)) {
            throw new InvalidArgumentException("Payment store [{$this->method->name}] is not defined.");
        }

        try {
            
            $driverCLass = $provider['driver'];
            $credentials = $this->getCredentials();

            return new $driverCLass($credentials);

        } catch (\Exception $e) {
            throw new InvalidArgumentException("Driver [{$provider['driver']}] is not supported.");
        }
    }

    /**
     * Get the default payment driver name.
     *
     * @return string
     */
    private function getCredentials()
    {
        return $this->method->credentials->mapWithKeys(function($item) {
            return [$item->name => $item->value];
        })->toArray();
    }

    public function getProvider($method_id)
    {
        $this->method = Cache::rememberForever("payment.stores.{$method_id}", function () use ($method_id) {
            return $this->repository()->findWithCredentials($method_id);
        });

        return $this->app['config']["payment.providers.{$this->method->provider}"];
    }

    /**
     * Load payment method from cache
     * This get cache and turns array into \Illuminate\Database\Eloquent\Collection
     */
    private function loadMethods()
    {
        if ($this->methods !== null) {
            return;
        }

    }

    /**
     * Create a new payment repository with the given implementation.
     *
     * @return \App\Models\Repositories\PaymentRepository
     */
    private function repository()
    {
        return new PaymentRepository();
    }

    /**
     * Get the default payment driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return config('payment.driver');
    }



}
