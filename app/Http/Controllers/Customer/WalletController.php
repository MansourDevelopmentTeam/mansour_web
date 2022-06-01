<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Customer\WalletHistoryResource;
use App\Models\Orders\OrderState;
use App\Models\Products\Ad;
use App\Models\Repositories\WalletRepository;
use App\Models\Transformers\Customer\AdsTransformer;
use App\Models\Users\User;
use App\Models\Users\Affiliates\WalletHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    private $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
        $this->middleware('affiliate_enable');
    }

    public function index(Request $request)
    {
        $request->merge(['affiliate_id' => auth()->User()->id]);
        $walletHistory = $this->walletRepository->getPaginatedAffiliateWalletHistory($request);
        return $this->jsonResponse("Success", ['wallet' => WalletHistoryResource::collection($walletHistory) , 'total' => $walletHistory->total()]);
    }

    public function statistics(Request $request)
    {
        $request->merge(['affiliate_id' => auth()->User()->id]);
        $walletStatistics = $this->walletRepository->getAffiliateWalletStatistics($request);
        return $this->jsonResponse("Success", $walletStatistics);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "amount" => "required|numeric",
            "payment_method" => "required|in:1,2",
            "phone_number" => "nullable|required_if:payment_method,1|min:10",
            "bank_name" => "nullable|required_if:payment_method,2|string",
            "account_name" => "nullable|required_if:payment_method,2|string",
            "account_number" => "nullable|required_if:payment_method,2|integer",
            "iban" => "sometimes|nullable",
        ]);
        $request->merge(['affiliate_id' => auth()->User()->id]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $availableWalletBalance = $this->walletRepository->getAvailableWalletBalance($request);
        if ($request->amount > $availableWalletBalance) {
            return $this->errorResponse(trans('web.withdrawAmountError'), "Invalid data", $validator->errors(), 422);
        }
        $data = $validator->validated();
        $data['order_id'] = null;
        $data['type'] = 3;
        $data['status'] = 0;
        $data['affiliate_id'] = auth()->User()->id;
        $wallet = WalletHistory::create($data);

        $walletStatistics = $this->walletRepository->getAffiliateWalletStatistics($request);
        return $this->jsonResponse("Success", ['wallet' => new WalletHistoryResource($wallet) , 'statistics' => $walletStatistics]);
    }
}
