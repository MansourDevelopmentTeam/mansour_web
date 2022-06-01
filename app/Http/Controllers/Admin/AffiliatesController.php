<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\Admin\AffiliateSimpleResource;
use App\Models\Repositories\AffiliateRepository;
use App\Models\Repositories\WalletRepository;
use App\Sheets\Export\Affiliates\AffiliatesExport;
use App\Sheets\Export\Customers\CustomersExport;
use App\Models\ACL\Role;
use App\Models\Repositories\CustomerRepository;
use App\Models\Services\PushService;
use App\Models\Transformers\CustomerFullTransformer;
use App\Models\Transformers\CustomerSimpleTransformer;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class AffiliatesController extends Controller
{
    private $customerRepo;
    private $customerTrans;
    private $pushService;
    private $fullTrans;
    private $walletRepository;
    private $affiliateRepository;

    public function __construct(AffiliateRepository $affiliateRepository,WalletRepository $walletRepository, CustomerRepository $customerRepo, CustomerSimpleTransformer $customerTrans, CustomerFullTransformer $fullTrans, PushService $pushService)
    {
        $this->customerRepo = $customerRepo;
        $this->customerTrans = $customerTrans;
        $this->fullTrans = $fullTrans;
        $this->pushService = $pushService;
        $this->walletRepository = $walletRepository;
        $this->affiliateRepository = $affiliateRepository;
    }

    public function index(Request $request)
    {
        $affiliates = User::where("type", 4)->when($request->q, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->orWhere("name", "LIKE", "%{$request->q}%")
                    ->orWhere("email", "LIKE", "%{$request->q}%")
                    ->orWhere("phone", "LIKE", "%{$request->q}%")
                    ->orWhere("id", "LIKE", "%{$request->q}%");
            });
        })->orderBy("created_at", "DESC")->paginate(20);

        return $this->jsonResponse("Success", ["affiliates" => AffiliateSimpleResource::collection($affiliates), "total" => $affiliates->total()]);
    }

    public function show($id, Request $request)
    {

        $affiliate = User::where("type", 4)->where("id", $id)->firstOrFail();
        $request->merge(['affiliate_id' => $affiliate->id]);
        $affiliateStatistics = $this->walletRepository->getAffiliateWalletStatistics($request);
        return $this->jsonResponse("Success", ['affiliate' => $this->fullTrans->transform($affiliate), 'affiliate_statistics' => $affiliateStatistics]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "last_name" => "sometimes|nullable",
            "phone" => "required",
            "email" => "required|email|unique:users,email",
            "image" => "sometimes|nullable",
            "birthdate" => "sometimes|nullable",
            "password" => "required|min:8"
        ]);
        $data = $validator->validated();

        if (User::where("phone", $request->phone)->where("phone_verified", 1)->exists()) {
            return $this->errorResponse("Phone number already registered", "Invalid data", [], 400);
        }

        $data['type'] = 4;
        $data['active'] = 1;
        $data['phone_verified'] = 1;
        $data['password'] = bcrypt($request->password);
        $affiliate = User::create($data);
        $affiliate->refresh();
        $settings = $affiliate->settings()->firstOrCreate(['language' => 'en']);
        if($request->closed_payment_methods) {
            $affiliate->closedPaymentMethods()->sync($request->closed_payment_methods);
        }
        $affiliateLink = $this->affiliateRepository->createAffiliateLink($affiliate, config('app.website_url'));
        return $this->jsonResponse("Success", $this->customerTrans->transform($affiliate));
    }

    public function update(Request $request, $id)
    {
        $affiliate = User::where("type", 4)->where("id", $id)->firstOrFail();
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "last_name" => "sometimes|nullable",
            "phone" => "required",
            "email" => "required|email|unique:users,email,{$id}",
            "image" => "sometimes|nullable",
            "birthdate" => "sometimes|nullable",
            "password" => "sometimes|nullable|min:8",
        ]);

        if ($request->phone && User::where("phone", $request->phone)->where("phone_verified", 1)->where("id", "!=", $id)->exists()) {
            return $this->errorResponse("Phone number already registered", "Invalid data", [], 400);
        }
        $data = $validator->validated();
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $affiliate->update($data);

        if (empty($request->closed_payment_methods)) {
            $affiliate->closedPaymentMethods()->detach();
        } else {
            $affiliate->closedPaymentMethods()->sync($request->closed_payment_methods);
        }
        return $this->jsonResponse("Success", $this->customerTrans->transform($affiliate));
    }

    public function activate($id)
    {
        $affiliate = User::where("type", 4)->where("id", $id)->firstOrFail();

        $affiliate->active = 1;
        $affiliate->deactivation_notes = null;
        $affiliate->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $validator = Validator::make($request->all(), ["deactivation_notes" => "required"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $affiliate = User::where("type", 4)->where("id", $id)->firstOrFail();

        $affiliate->active = 0;
        $affiliate->deactivation_notes = $request->deactivation_notes;
        $affiliate->save();

        return $this->jsonResponse("Success");
    }

    public function approveHistory($affilateID, $historyID)
    {
        $affiliate = User::where("type", 4)->where("id", $affilateID)->firstOrFail();
        $affiliateHistory = $affiliate->walletHistory()->where('status', 0)->where('id', $historyID)->firstOrFail();
        $affiliateHistory->update(['status' => 1]);
        return $this->jsonResponse("Success");
    }

    public function rejectHistory($affilateID, $historyID)
    {
        $affiliate = User::where("type", 4)->where("id", $affilateID)->firstOrFail();
        $affiliateHistory = $affiliate->walletHistory()->where('status', 0)->where('id', $historyID)->firstOrFail();
        $affiliateHistory->update(['status' => 2]);
        return $this->jsonResponse("Success");
    }

    public function walletExport(Request $request)
    {
        $walletHistories = $this->walletRepository->getFilteredWalletHistoryQuery($request)->get();
        $fileName = 'wallet_histories_' . date("Y-m-d-H-i-s");
        Excel::create($fileName, function ($excel) use ($walletHistories) {
            $excel->sheet('report', function ($sheet) use ($walletHistories) {
                // $sheet->fromArray($players);
                $sheet->row(1, ["id", "date", "affiliate_id", "affiliate_name", "affiliate_phone", "affiliate_email", "order_id", "type", "state", "total"]);

                foreach ($walletHistories as $key => $walletHistory) {
                    // dd(array_values($player));
                    $sheet->row($key + 2, [
                        $walletHistory->id,
                        date("Y-m-d", strtotime($walletHistory->created_at)),
                        $walletHistory->affiliate->id,
                        $walletHistory->affiliate->name,
                        $walletHistory->affiliate->phone,
                        $walletHistory->affiliate->email,
                        $walletHistory->order_id,
                        $walletHistory->type_string,
                        $walletHistory->status_string,
                        $walletHistory->amount
                    ]);
                }
            });
        })->store('xlsx', storage_path("app/public/exports"));
        $filePath = url("storage/exports") . '/' . $fileName . '.xlsx';
        Log::info("Export Finished", ["path" => $filePath]);
        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $filePath, \Auth::id());
        return $this->jsonResponse("Success");
    }

    public function affiliatesExport(Request $request)
    {
        $affiliates = User::where("type", 4)->when($request->q, function ($q) use ($request) {
            $q->where(function ($q) use ($request) {
                $q->orWhere("name", "LIKE", "%{$request->q}%")
                    ->orWhere("email", "LIKE", "%{$request->q}%")
                    ->orWhere("phone", "LIKE", "%{$request->q}%")
                    ->orWhere("id", "LIKE", "%{$request->q}%");
            });
        })->get();
        $fileName = 'affiliates_' . date("Y-m-d-H-i-s");
        Excel::create($fileName, function ($excel) use ($affiliates) {
            $excel->sheet('report', function ($sheet) use ($affiliates) {
                // $sheet->fromArray($players);
                $sheet->row(1, ["id", "name", "email", "birthdate", "contact", "total_orders","language", "active"]);
                foreach ($affiliates as $key => $affiliate) {
                    // dd(array_values($player));
                    $sheet->row($key + 2, [
                        $affiliate->id,
                        $affiliate->name,
                        $affiliate->email,
                        $affiliate->birthdate ? date("Y-m-d", strtotime($affiliate->birthdate)) : "",
                        $affiliate->phone,
                        $affiliate->orders->count(),
                        $affiliate->settings->language ?? null,
                        (int)$affiliate->active
                    ]);
                }
            });
        })->store('xlsx', storage_path("app/public/exports"));
        $filePath = url("storage/exports") . '/' . $fileName . '.xlsx';
        Log::info("Export Finished", ["path" => $filePath]);
        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $filePath, \Auth::id());
        return $this->jsonResponse("Success");
    }
}
