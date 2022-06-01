<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\OrderCancellationReasonResource;
use App\Models\Orders\OrderCancellationReason;
use Illuminate\Http\Request;

class OrderCancellationReasonController extends Controller
{
    public function index()
    {
        $reasons = OrderCancellationReason::where('user_type', 'customer')->get();
        return $this->jsonResponse("Success", OrderCancellationReasonResource::collection($reasons));
    }
}
