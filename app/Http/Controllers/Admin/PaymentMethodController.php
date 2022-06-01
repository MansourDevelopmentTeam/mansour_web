<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Payment\PaymentMethod;
use App\Http\Requests\Admin\PaymentMethodRequest;

class PaymentMethodController extends Controller
{
    /**
     * List payment methods.
     *
     * @return void
     */
    public function index()
    {
        return $this->jsonResponse('success', PaymentMethod::all());
    }

    public function store(PaymentMethodRequest $request)
    {
        DB::beginTransaction();

        try {
            $paymentMethod = PaymentMethod::create($request->validated());

            $credentials = $this->getPaymentCredentialData();
            $paymentMethod->credentials()->createMany($credentials);
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
        }

        return $this->jsonResponse('success', $paymentMethod);
    }

    /**
     * Get credential by provider
     *
     * @param string $provider
     * @return void
     */
    public function getCredentialByProvider($provider)
    {
        $credentialConfig = config("payment.providers.{$provider}.credentials");

        return $this->jsonResponse('success', $credentialConfig);
    }

    /**
     * Update payment method.
     *
     * @param PaymentMethodRequest $request
     * @param PaymentMethod $paymentMethod
     * @return void
     */
    public function update(PaymentMethodRequest $request, PaymentMethod $paymentMethod)
    {
        $paymentMethod->update($request->validated());

        if($paymentMethod->wasChanged('provider')){
            $paymentMethod->credentials()->delete();

            $credentials = $this->getPaymentCredentialData();
            $paymentMethod->credentials()->createMany($credentials);
        }
        return $this->jsonResponse('success', $paymentMethod);
    }

    /**
     * Activate payment method
     *
     * @param PaymentMethod $method
     * @return void
     */
    public function activate(PaymentMethod $method)
    {
        $method->update(['active' => 1]);
        return $this->jsonResponse('success', $method);
    }

    /**
     * Deactivate payment method
     *
     * @param PaymentMethod $method
     * @return void
     */
    public function deactivate(PaymentMethod $method)
    {
        request()->validate([
            'deactivation_notes' => 'required',
        ]);
        $method->update([
            'active' => 0,
            'deactivation_notes' => request()->get('deactivation_notes')
        ]);
        return $this->jsonResponse('success', $method);
    }

    /**
     * get payment credential data from request
     *
     * @return void
     */
    private function getPaymentCredentialData()
    {
        $credentials = [];
        $row = 0;
        $provider = request()->get('provider');
        $credentialInputs = Arr::only(request()->get('credentials'), config("payment.providers.{$provider}.credentials"));

        foreach ($credentialInputs as $key => $value) {
            $credentials[$row]['name'] = $key;
            $credentials[$row]['value'] = $value;
            ++$row;
        }
        return $credentials;
    }
}
