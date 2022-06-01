<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Orders\OrderCancellationReason;
use Illuminate\Http\Request;

class OrderCancellationReasonController extends Controller
{
    public function index()
    {
        $reasons = OrderCancellationReason::all();
        return $this->jsonResponse("Success", $reasons);
    }
}
