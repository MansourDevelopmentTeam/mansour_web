<?php

namespace App\Http\Controllers;

use App\Facade\Sms;
use App\Facade\Payment;
use Illuminate\Http\Request;
use App\Models\Orders\Transaction;
use App\Console\Commands\UpdateOrdersGrandTotal;

/**
 * Test Controller Class
 * @author Esmail Shabayek <esmail.shaabyek@gmail.com>
 * @package App\Http\Controllers\TestController
 */
class TestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $payment = Payment::store(2);
        dd($payment->getPaymentUrl());
        
        $test = Sms::send('01097072480');
        dd($test);
        dd(app()->environment('production'));
        $payment_method_id = 17;
        $payment = \App\Facade\Payment::store($payment_method_id);

        dd($payment);

        // if($payment->isOnline()){

        //     $payUrl = $payment->getPaymentUrl();
        //     return $this->jsonResponse("Success", ['pay_url' => $payUrl], $payment->getResponseCode());
        // }

        $transaction = Transaction::find(21190);
        $callback = $payment->completePayment($transaction);

        

        dd($callback);

        // dispatch(new UpdateOrdersGrandTotal());
        dd('hi');
        //        $order = Order::find(3408);
        //        $order->customer->settings ? app()->setLocale($order->customer->settings->language) : app()->setLocale('en');
        //
        //        return view('emails.order_edited', ['order' => $order]);

        //      UpdateOrderPickupStatus::dispatch();
        //        dd('hiiiiii');

        //getCountries
        //        $data = Aramex::fetchCountries();
        //        $countryCode = "EG";
        //        $data = Aramex::fetchCountries($countryCode);

        //        $shipments = ["43829007913"];
        //        $data = Aramex::trackShipments($shipments);

        //         dd($data);
        //getCountry Cites
        //        $data = Aramex::fetchCities($countryCode);
        //        return $data->Cities->string;
        // dd($data);

        //Validate Address
        //        $data = Aramex::validateAddress([
        //            'line1' => 'Test', // optional (Passing it is recommended)
        //            'line2' => 'Test', // optional
        //            'line3' => 'Test', // optional
        //            'country_code' => 'EG',
        //            'postal_code' => '', // optional
        //            'city' => 'Abasya',
        //        ]);


        //Validate Address
        //        $data = Aramex::validateAddress([
        //            'line1' => 'Test', // optional (Passing it is recommended)
        //            'line2' => 'Test', // optional
        //            'line3' => 'Test', // optional
        //            'country_code' => 'EG',
        //            'postal_code' => '', // optional
        //            'city' => 'Abasya',
        //        ]);


        // Calculate Rate

        //        $originAddress = [
        //            'line_1' => 'Test string',
        //            'city' => 'Amman',
        //            'country_code' => 'JO'
        //        ];
        //
        //        $destinationAddress = [
        //            'line_1' => 'Test String',
        //            'city' => 'Dubai',
        //            'country_code' => 'AE'
        //        ];
        //
        //        $shipmentDetails = [
        //            'weight' => 5, // KG
        //            'number_of_pieces' => 2,
        //            'payment_type' => 'P', // if u don't pass it, it will take the config default value
        //            'product_group' => 'EXP', // if u don't pass it, it will take the config default value
        //            'product_type' => 'PPX', // if u don't pass it, it will take the config default value
        //            'height' => 5.5, // CM
        //            'width' => 3,  // CM
        //            'length' => 2.3  // CM
        //        ];
        //
        //        $shipmentDetails = [
        //            'weight' => 5, // KG
        //            'number_of_pieces' => 2,
        //        ];
        //
        //        $currency = 'USD';
        //        $data = Aramex::calculateRate($originAddress, $destinationAddress , $shipmentDetails , 'USD');
        //
        //        if(!$data->error){
        //            dd($data);
        //        }
        //        else{
        //            // handle $data->errors
        //        }


        //cancel picup
        //        $data = Aramex::cancelPickup('7480f4b4-fd36-4679-bf23-fae7d89148f3', 'ana asef ya basha ana 3yl so5yr');
        //        dd($data);
    }
}
