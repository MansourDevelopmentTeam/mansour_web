<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment\ClosedPaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClosedPaymentMethodController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            "user_id" => "required",
            "payment_method_id" => "required"
        ]);
        $closed = ClosedPaymentMethod::create($data);
        return $this->jsonResponse('success', $closed);
    }
}
