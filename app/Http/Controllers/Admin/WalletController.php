<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\WalletHistoryResource;
use App\Models\Repositories\WalletRepository;
use App\Models\Users\User;
use App\Models\Users\Affiliates\WalletHistory;
use Facades\App\Models\Services\UploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    private $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }
    public function index(Request $request)
    {
        $walletHistory = $this->walletRepository->getPaginatedFilteredAffiliatesWalletHistory($request);
        $walletHistoryStatistics = $this->walletRepository->getFilteredAffiliateWalletStatistics($request);
        return $this->jsonResponse("Success", ['wallet' => WalletHistoryResource::collection($walletHistory), 'statistics'=>$walletHistoryStatistics,'total' => $walletHistory->total()]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "affiliate_id" => "required|exists:users,id",
            "rejection_reason" => "sometimes|nullable",
            "admin_comment" => "sometimes|nullable",
            "amount" => "required|numeric",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $affiliate = User::where('id', $request->affiliate_id)->where('type', 4)->first();
        if (!$affiliate) {
            return $this->errorResponse("Affiliate Not Found", "Invalid data", [], 422);
        }
        $walletData = [
            "affiliate_id" => $affiliate->id,
            "order_id" => null,
            "amount" => $request->amount,
            "admin_comment" => $request->admin_comment,
            "rejection_reason" => $request->rejection_reason,
            "type" => 2,
            "status" => 1,
        ];
        $wallet = WalletHistory::create($walletData);
        return $this->jsonResponse("Success", new WalletHistoryResource($wallet));
    }
    public function approve($id)
    {
        $walletRecord = WalletHistory::where('id',$id)->firstOrFail();
        $walletRecord->update(['status'=>1]);
        return $this->jsonResponse("Success", new WalletHistoryResource($walletRecord) );
    }
    public function reject(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            "rejection_reason" => "sometimes|nullable",
            "admin_comment" => "sometimes|nullable",
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->validated();
        $data['status'] = 2;
        $walletRecord = WalletHistory::where('id',$id)->where('status',0)->firstOrFail();
        $walletRecord->update($data);
        return $this->jsonResponse("Success",new WalletHistoryResource($walletRecord) );
    }
}
