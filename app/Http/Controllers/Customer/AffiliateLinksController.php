<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\AffiliateLinksResource;
use App\Models\Repositories\AffiliateLinksRepository;
use App\Models\Repositories\AffiliateRepository;
use App\Models\Users\Affiliates\AffiliateLinks;
use App\Models\Users\Affiliates\AffiliateRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AffiliateLinksController extends Controller
{
    private $affiliateRepository;
    private $affiliateLinksRepository;

    public function __construct(AffiliateRepository $affiliateRepository, AffiliateLinksRepository $affiliateLinksRepository)
    {
        $this->affiliateRepository = $affiliateRepository;
        $this->affiliateLinksRepository = $affiliateLinksRepository;
        $this->middleware('affiliate_enable');
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $links = $user->affiliateLinks()->orderBy('created_at', 'DESC')->paginate(20);
        return $this->jsonResponse("Success", ["links" => AffiliateLinksResource::collection($links), "total" => $links->total()]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $validator = Validator::make($request->all(), [
            "url" => "required|min:3",
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $affiliateLink = $this->affiliateRepository->createAffiliateLink($user, $request->url);
        if (!$affiliateLink) {
            return $this->errorResponse("Invalid data Please Enter Valid Url", "Invalid data Please Enter Valid Url", [], 422);
        }
        // return success
        return $this->jsonResponse("Success", new AffiliateLinksResource($affiliateLink));
    }

    public function storeHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "referral" => "required|min:20",
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $affiliateLink = $this->affiliateLinksRepository->storeHistory($request->referral);
        if (!$affiliateLink) {
            return $this->errorResponse("Invalid data", "Invalid data", [], 422);
        }

        // return success
        return $this->jsonResponse("Success", $affiliateLink);
    }
}
