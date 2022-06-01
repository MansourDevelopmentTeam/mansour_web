<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\ACL\Role;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Services\PushService;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Models\Repositories\CustomerRepository;
use App\Sheets\Export\Customers\CustomersExport;
use App\Models\Transformers\CustomerFullTransformer;
use App\Models\Transformers\CustomerSimpleTransformer;
use App\Sheets\Export\Customers\CustomersCartItemsExport;

class CustomersController extends Controller
{
    protected $customerRepo;
    protected $customerTrans;
    protected $fullTrans;
    protected $pushService;

    /**
     * Constructor
     *
     * @param CustomerRepository $customerRepo
     * @param CustomerSimpleTransformer $customerTrans
     * @param CustomerFullTransformer $fullTrans
     * @param PushService $pushService
     */
    public function __construct(CustomerRepository $customerRepo, CustomerSimpleTransformer $customerTrans, CustomerFullTransformer $fullTrans, PushService $pushService)
    {
        $this->customerRepo = $customerRepo;
        $this->customerTrans = $customerTrans;
        $this->fullTrans = $fullTrans;
        $this->pushService = $pushService;
    }


    public function index(Request $request)
    {
        $query = User::with("addresses.area")->where("type", 1)->where('id', '!=', 999999);

        $customer = $this->customerRepo->searchCustomers($request->all(), $query);

        $customers = $customer->paginate(20);

        return $this->jsonResponse("Success", ["customers" => $this->customerTrans->transformCollection($customers->items()), "total" => $customers->total()]);
    }

    public function simpleList()
    {
        $customers = User::with("addresses")->where("type", 1)->where('id', '!=', 999999)->get(["id", "name"]);

        return $this->jsonResponse("Success", $customers);
    }

    /**
     * Search in customers
     *
     * @param Request $request
     * @return void
     * @api  /api/admin/customers/search GET Reauest
     */
    public function search(Request $request)
    {
        $query = User::with("addresses.area")->where("type", 1)->where('id', '!=', 999999);

        $customer = $this->customerRepo->searchCustomers($request->all(), $query);

        $customers = $customer->get();

        return $this->jsonResponse("Success", ["customers" => $this->customerTrans->transformCollection($customers), "total" => $customers->count()]);
    }

    /**
     * Search in customers
     *
     * @param Request $request
     * @return void
     * @api  /api/admin/customers/search POST Reauest
     */
    public function searchCustomers(Request $request)
    {
        $query = User::with("addresses.area")->where("type", 1)->where('id', '!=', 999999);

        $customer = $this->customerRepo->searchCustomers($request->all(), $query);

        $customers = $customer->paginate(20);

        return $this->jsonResponse("Success", ["customers" => $this->customerTrans->transformCollection($customers->items()), "total" => $customers->total()]);
    }

    /**
     * Store customer with address
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "last_name" => "required",
            "phone" => "required",
            "email" => "nullable|email|unique:users,email",
            "birthdate" => "sometimes|nullable",
            "password" => "required|min:8",
            "code" => "required|string"
        ]);

        DB::beginTransaction();
        
        try {
            $oldUser = User::where("phone", $request->phone)->first();

            if ($oldUser) {
                if ($oldUser->phone_verified) {
                    return $this->errorResponse("Phone number already registered", "Invalid data", [], 400);
                }
                $oldUser->update([
                    "phone" => null,
                    "phone_verified" => 0
                ]);
            }
    
            $request->merge(["type" => 1, "password" => bcrypt($request->password), "active" => 1, "phone_verified" => 0]);
            $user = User::create($request->only(["name", "last_name", "phone", "email", "password", "type", "active", "phone_verified", "birthdate", "code"]));
    
            if (!$user->referal) {
                $user->referal = $user->generateReferal();
                $user->save();
            }
            
            $user->refresh();
    
            $user->settings()->firstOrCreate(['language' => 'en']);
    
            if($request->has('address') && $request->get('has_address')){
    
                $address = $user->addresses()->create($request->get('address'));

                if ($request->input('address.primary') === true) {
                    $user->addresses()->where('id', '!=', $address->id)->update(["primary" => 0]);
                    $address->primary = 1;
                    $address->save();
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
        }

        return $this->jsonResponse("Success", $this->customerTrans->transform($user));
    }

    /**
     * Update customer api from admin
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "name" => "required",
//            "last_name" => "required",
            "phone" => "required",
            "email" => "nullable|email|unique:users,email,{$id}",
            "birthdate" => "sometimes|nullable",
            "password" => "sometimes|nullable|min:8",
            "closed_payment_methods" => "sometimes|array",
            "code" => "required|string"
        ]);
        DB::beginTransaction();

        try {
            $oldUser = User::where("phone", $request->phone)->where("id", "!=", $id)->first();

            if ($oldUser) {
                if ($oldUser->phone_verified) {
                    return $this->errorResponse("Phone number already registered", "Invalid data", [], 400);
                }
                $oldUser->update([
                    "phone" => null,
                    "phone_verified" => 0
                ]);
            }
            $user = User::where("id", $id)->where("type", 1)->first();

            $request->merge(["phone_verified" => 0]);
            $user->update($request->only(["name", "last_name", "phone", "email", "birthdate", "phone_verified", "code"]));
            if ($request->password) {
                $user->update(["password" => bcrypt($request->password)]);
            }

            if (!$user->referal) {
                $user->referal = $user->generateReferal();
                $user->save();
            }

            if ($request->closed_payment_methods) {
                $user->closedPaymentMethods()->sync($request->closed_payment_methods);
            }
            DB::commit();
            return $this->jsonResponse("Success", $this->customerTrans->transform($user));
        } catch (\Exception $e) {
            DB::rollback();
        }
    }


    public function show($id)
    {
        $customer = $this->customerRepo->getCustomerById($id);

        return $this->jsonResponse("Success", $this->fullTrans->transform($customer));
    }

    public function activate($id)
    {
        $customer = $this->customerRepo->getCustomerById($id);

        $customer->active = 1;
        $customer->deactivation_notes = null;
        $customer->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $validator = Validator::make($request->all(), ["deactivation_notes" => "required"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $customer = $this->customerRepo->getCustomerById($id);

        $customer->active = 0;
        $customer->deactivation_notes = $request->deactivation_notes;
        $customer->save();

        return $this->jsonResponse("Success");
    }

    /**
     * Export customers api
     *
     * @return void
     */
    public function export()
    {

        $fileName = 'customer_by_' . auth()->user()->name . '_' . date("Y_m_d H_i_s"). '.xlsx';
        $filePath = 'public/exports/customers/customers_' . $fileName;
        $fileUrl = url("storage/exports/customers") . '/customers_' . $fileName;
        Excel::store(new CustomersExport(), $filePath);
        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $fileUrl, auth()->User()->id);
        return $this->jsonResponse("Success");
    }

    public function exportCartItems()
    {
        $fileName = date("YmdHis") . '.xlsx';
        $filePath = 'public/exports/customers/customersItems_' . $fileName;
        $fileUrl = url("storage/exports/customers") . '/customersItems_' . $fileName;
        Excel::store(new CustomersCartItemsExport(), $filePath);
        $this->pushService->notifyAdmins("File Exported ", "Your export has completed! You can download the file from", '', 11, $fileUrl, auth()->User()->id);
        return $this->jsonResponse("Success");
    }

    public function verifyPhone($id)
    {
        $user = User::findOrFail($id);

        $user->phone_verified = 1;
        $user->save();

        return $this->jsonResponse("Success", $this->fullTrans->transform($user));
    }

    public function getCustomerToken($id)
    {
        $customer = $this->customerRepo->getCustomerById($id);

        $token = JWTAuth::fromUser($customer);

        return $this->jsonResponse("Success", $token);
    }
}
