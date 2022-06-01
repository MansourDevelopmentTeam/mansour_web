<?php

namespace App\Http\Controllers\Customer;

use App\Models\Configuration;
use App\Models\Localization\Country;
use App\Http\Controllers\Controller;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configs = Configuration::scope('customer')->get()->pluck('value', 'key');

        $localization = Country::where('country_code', config('app.country_code'))->first();
        if(!$localization) {
            $localization = Country::where('fallback', true)->first();
        }

        $configs['localization'] = $localization;

        return $this->jsonResponse('success', $configs);
    }
}
