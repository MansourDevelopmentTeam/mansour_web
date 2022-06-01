<?php

namespace Database\Seeders;

use App\Models\Payment\PaymentCredential;
use App\Models\Payment\PaymentMethod;
use Illuminate\Database\Seeder;
use Log;

class PaymentMethods extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $paymentMethods = config('payment.stores');
        foreach ($paymentMethods as $id => $configMethod) {
            $method = PaymentMethod::firstOrCreate([
                'id' => $id,
            ], [
                'id' => $id,
                'name' => $configMethod['name_en'],
                'name_ar' => $configMethod['name_ar'],
                'is_online' => $configMethod['isOnline'],
                'icon' => $configMethod['icon'],
                'active' => $configMethod['isActive']
            ]);

            // if(isset($configMethod['credentials'])) {
            //     foreach ($configMethod['credentials'] as $key => $credential) {
            //         $credentialData = [
            //             'method_id' => $method->id
            //         ];
            //         $defaultArr = [];
            //         if(is_string($key)) {
            //             $credentialData['name'] = $key;
            //             $defaultArr['default'] = $credential;
            //         } else {
            //             $credentialData['name'] = $credential;
            //         }
            //         PaymentCredential::updateOrCreate($credentialData, $defaultArr);
            //     }
            // }
            Log::info("{$configMethod['name_en']} -> seeded");
        }
    }
}
