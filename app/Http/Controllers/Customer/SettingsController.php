<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = config('constants.enable_affiliate');
        return $this->jsonResponse("Success", $settings);
    }
}
