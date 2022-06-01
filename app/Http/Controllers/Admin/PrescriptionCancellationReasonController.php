<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medical\PrescriptionCancellationReason;
use Illuminate\Http\Request;

class PrescriptionCancellationReasonController extends Controller
{
    public function index()
    {
        $reasons = PrescriptionCancellationReason::where('user_type', 'admin')->get();
        return $this->jsonResponse("Success", $reasons);
    }
}
