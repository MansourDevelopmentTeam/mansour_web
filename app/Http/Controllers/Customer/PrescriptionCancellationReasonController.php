<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\PrescriptionCancellationReasonResource;
use App\Models\Medical\PrescriptionCancellationReason;
use Illuminate\Http\Request;

class PrescriptionCancellationReasonController extends Controller
{
    public function index()
    {
        $reasons = PrescriptionCancellationReason::where('user_type', 'customer')->get();
        return $this->jsonResponse("Success", PrescriptionCancellationReasonResource::collection($reasons));
    }
}
