<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Users\Affiliates\AffiliateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AffiliateRequestsController extends Controller
{

    public function __construct()
    {
        $this->middleware('affiliate_enable');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:3",
            "last_name" => "required|min:3",
            "password" => "required|min:8",
            "email" => "required|unique:affiliate_requests,email|email",
            "phone" => "required|unique:affiliate_requests,phone",
            "birthdate" => "sometimes|nullable|before:" . date("Y-m-d"),
            "image" => "sometimes|nullable",
        ], ["email.unique" => Lang::get("mobile.errorEmailUsed"), "name.min" => trans("mobile.errorNameMin")]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->validated();
        $data['password'] = Hash::make($request->password);
        if (auth()->check()) {
            $data['user_id'] = auth()->User()->id;
        }
        $affiliate = AffiliateRequest::create($data);
        // return success
        return $this->jsonResponse("Success", $affiliate);
    }
}
