<?php

namespace App\Classes\Payment\Drivers;

use Exception;
use App\Models\Orders\Transaction;
use App\Models\Repositories\CartRepository;
use App\Models\Repositories\TransactionRepository;

/**
 * Driver abstract class
 * @package App\Classes\Payment\Drivers
 */
abstract class Method
{
    /**
     * Order service
     *
     * @var \App\Models\Services\OrdersService
     */
    protected $orderService;
    /**
     * Grand total will pay
     *
     * @var [type]
     */
    protected $totalPay;
    /**
     * @var mixed
     */
    protected $isOnline;
    /**
     * @var mixed
     */
    protected $isActive;
    /**
     * @var mixed
     */
    protected $isInstallment;
    /**
     * Payment service
     *
     * @var [type]
     */
    public $paymentService;
    /**
     * Response status code
     *
     * @var integer
     */
    protected $responseCode;
    /**
     * payment config
     *
     * @var array
     */
    public $config = [];
    /**
     * Cart object
     *
     * @var object
     */
    protected $cart;
    /**
     * Customer object
     *
     * @var User|null
     */
    protected $customer;
    /**
     * Transaction object
     * @var Transaction
     */
    protected $transactionRepo;

    /**
     * Method constructor.
     *
     * @param Array $config
     */
    public function __construct(Array $config)
    {
        $this->isOnline = $config['isOnline'];
        $this->isActive = $config['isActive'];
        $this->isInstallment = $config['isInstallment'];
        $this->config = $config;
        $this->orderService = app()->make('App\Models\Services\OrdersService');
        $this->transactionRepo = new TransactionRepository;
        $this->setResponseCode(200);
    }

    /**
     * Get total amount
     *
     * @return void
     */
    public function getTotalPay()
    {
        try {
            $amount = $this->orderService->getTotalAmount(request()->all(), true);

            if ($this->isInstallment) {
                $this->totalPay = $amount['total'];
            } else {
                $this->totalPay = $amount['grand_total'];
            }

            return $amount;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return mixed
     */
    public function isOnline()
    {
        return $this->isOnline;
    }
    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->isActive;
    }
    /**
     * @return mixed
     */
    public function isInstallment()
    {
        return $this->isInstallment;
    }
    /**
     * Set response code status
     *
     * @return void
     */
    public function setResponseCode(int $code)
    {
        $this->responseCode = $code;
    }
    /**
     * Get the value of responseCode
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }
    /**
     * Assign cart
     *
     * @var void
     */
    public function setCart()
    {
        if (!$this->cart) {
            $this->cart = (new CartRepository())->getUserCartItems($this->customer);
        }
    }

    /**
     * Return cart items
     *
     * @var Collection
     */
    public function getCartItems()
    {
        if (! $this->cart) {
            $this->setCart();
        }

        return $this->cart;
    }
    /**
     * Set customer object
     *
     * @param  User  $customer
     * @return  self
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }
}
