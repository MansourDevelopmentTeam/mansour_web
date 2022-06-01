<?php

namespace App\Http\Controllers\Admin;

use App\Mail\AffiliateRequestUpdate;
use App\Mail\OrderCreated;
use App\Models\Repositories\AffiliateRepository;
use App\Models\Repositories\CustomerRepository;
use App\Models\Services\PushService;
use App\Models\Transformers\CustomerFullTransformer;
use App\Models\Transformers\CustomerSimpleTransformer;
use App\Models\Users\Affiliates\AffiliateRequest;
use App\Models\Users\User;
use App\Models\Products\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;

class AffiliateRequestsController extends Controller
{
    private $customerTrans;
    private $affiliateRepository;

    public function __construct(CustomerSimpleTransformer $customerTrans, AffiliateRepository $affiliateRepository)
    {
        $this->customerTrans = $customerTrans;
        $this->affiliateRepository = $affiliateRepository;
    }

    public function index(Request $request)
    {
        $affiliates = AffiliateRequest::query()->with('user');
        $affiliates->when($request->status, function ($q) use ($request) {
            $q->where("status", $request->status);
        });
        $affiliates->when($request->q, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->orWhere("name", "LIKE", "%{$request->q}%")
                    ->orWhere("email", "LIKE", "%{$request->q}%")
                    ->orWhere("phone", "LIKE", "%{$request->q}%")
                    ->orWhere("id", "LIKE", "%{$request->q}%");
            });
        });
        $affiliates = $affiliates->where('status', '!=', 1)->paginate(20);
        return $this->jsonResponse("Success", ['affiliates' => $affiliates->items(), "total" => $affiliates->total()]);
    }

    public function approve($id)
    {

        $affiliate = AffiliateRequest::where('id', $id)->first();
        if (!$affiliate) {
            $message = 'Affiliate Not Found';
            return $this->errorResponse($message, "Invalid data", 422);
        }
        $affiliateData = [
            'name' => $affiliate->name,
            'last_name' => $affiliate->last_name,
            'email' => $affiliate->email,
            'phone' => $affiliate->phone,
            'image' => $affiliate->image,
            'password' => $affiliate->password,
            'affiliate_referral' => Str::random(20),
            'birthdate' => $affiliate->birthdate,
            'active' => 1,
            'phone_verified' => 1,
            'type' => 4
        ];
        $user = User::where('email', $affiliate->email)->first();

        if ($user) {
            if ($user->type == 4) {
                return $this->jsonResponse("Success");
            }
            $user->update(['type' => 4]);
        } else {
            $user = User::create($affiliateData);
        }
        $affiliate->update(['status' => 1, 'rejection_reason' => null]);
        $affiliateLink = $this->affiliateRepository->createAffiliateLink($user, config('app.website_url'));
        if (!$affiliateLink) {
            return $this->errorResponse("Invalid data Please Enter Valid Url", "Invalid data Please Enter Valid Url", [], 422);
        }
        $affiliate->user  && $affiliate->user->settings ? app()->setLocale($affiliate->user->settings->language) : app()->setLocale('en');
        Mail::to($affiliate->email)->send(new AffiliateRequestUpdate($affiliate));
        return $this->jsonResponse("Success");

    }

    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "rejection_reason" => "required|string",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $affiliate = AffiliateRequest::where('status', 0)->where('id', $id)->first();
        if (!$affiliate) {
            $message = 'affiliate Not Found';
            return $this->errorResponse($message, "Invalid data", 422);
        }
        $affiliate->update(['status' => 2, 'rejection_reason' => $request->rejection_reason]);
        $affiliate->user  && $affiliate->user->settings ? app()->setLocale($affiliate->user->settings->language) : app()->setLocale('en');
        Mail::to($affiliate->email)->send(new AffiliateRequestUpdate($affiliate));
        return $this->jsonResponse("Success");
    }

}
