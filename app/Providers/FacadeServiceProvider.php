<?php

namespace App\Providers;

use App\Classes\Sms\SmsEg;
use App\Classes\Sms\SmsMisr;
use App\Classes\Sms\VictoryLink;
use App\Classes\Payment\PaymentManager;
use Illuminate\Support\ServiceProvider;
use App\Classes\Payment\PaymentManagerv2;

class FacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sms',function() {
            $config = $this->app->config['integrations.sms'];

            if ($config['default'] == "smsmisr") {
                return new SmsMisr($config);
            } else if ($config['default'] == "victory") {
                return new VictoryLink($config);
            }else {
                return new SmsEg($config);
            }  
        });

        $this->app->bind('payment',function() {
            return new PaymentManager($this->app);
        });
    }

    // /**
    //  * Bootstrap services.
    //  *
    //  * @return void
    //  */
    // public function boot(PaymentManagerv2 $payment)
    // {
    //     $this->app->bind('payment', function () use($payment) {
    //         return $payment;
    //     });
    // }
}
