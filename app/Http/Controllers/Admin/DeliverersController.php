<?php

namespace App\Http\Controllers\Admin;

use App\Models\ACL\Role;
use App\Models\Repositories\DelivererRepository;
use App\Models\Transformers\DelivererFullTransformer;
use App\Models\Transformers\OrderDetailsTransformer;
use App\Models\Users\User;
use App\Models\Locations\District;
use App\Sheets\Export\Deliverers\DelivererOrdersExport;
use App\Sheets\Export\Deliverers\DeliverersExport;
use App\Sheets\Import\Deliverers\DeliverersImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class DeliverersController extends Controller
{
    private $delivererRepo;
    private $deliverTrans;
    private $orderTrans;

    /**
     * Constructor
     *
     * @param DelivererRepository $delivererRepo
     * @param DelivererFullTransformer $deliverTrans
     * @param OrderDetailsTransformer $orderTrans
     */
    public function __construct(DelivererRepository $delivererRepo, DelivererFullTransformer $deliverTrans, OrderDetailsTransformer $orderTrans)
    {
        $this->delivererRepo = $delivererRepo;
        $this->deliverTrans = $deliverTrans;
        $this->orderTrans = $orderTrans;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $deliverers = $this->delivererRepo->getAllDeliverersPaginated($request->all());

        return $this->jsonResponse("Success", ["deliverers" => $this->deliverTrans->transformCollection($deliverers->items()), "total" => $deliverers->total()]);
    }

    public function allDeliverers()
    {
        $deliverers = $this->delivererRepo->getAllDeliverers();

        return $this->jsonResponse("Success", $this->deliverTrans->transformCollection($deliverers));
    }

    public function orders($id)
    {
        $deliverer = $this->delivererRepo->getDelivererById($id);

        $orders = $deliverer->deliveries;

        return $this->jsonResponse("Success", $this->orderTrans->transformCollection($orders));
    }

    public function exportOrders($id)
    {
        return Excel::download(new DelivererOrdersExport($id), 'Deliverer_' . $id . '_orders_' . date("Ymd") . '.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "password" => "required",
            "phone" => "required|unique:users,phone",
            "email" =>  "required|unique:users,email",
            // "birthdate" => "required|before:" . date("Y-m-d"),
            "address" => "required",
            "role_id" => "required",
            // "unique_id" => "required|unique:deliverer_profiles,unique_id",
            "area_id" => "required|exists:areas,id",
            "city_id" => "required|exists:cities,id"
        ], [
            "phone.unique" => "This phone number is already registered", 
            "email.unique" => "This email is already registered", 
            "unique_id.unique" => "This unique id is already registered"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        if ($request->email) {
            $user = User::whereHas('delivererProfile')->where('email', $request->email)->first();
            if ($user) {
                return $this->errorResponse("This email is already registered", "Invalid data", [], 422);
            }
        }

        if ($request->phone) {
            $user = User::whereHas('delivererProfile')->where('phone', $request->phone)->first();
            if ($user) {
                return $this->errorResponse("This phone is already registered", "Invalid data", [], 422);
            }
        }

        DB::beginTransaction();
        try {
            $request->merge(["birthdate" => date("Y-m-d", strtotime($request->birthdate)), "type" => User::TYPE_DELIVERER]);

            $user = User::create($request->only(["name", "email", "phone", "birthdate", "type"]));
            $user->password = bcrypt($request->password);
            $user->active = 1;
            $user->save();

            $role = Role::find($request->role_id);
            $user->assignRole($role->name);

            $user->addresses()->create($request->only(["address"]));

            // store deliverer profile
            $deliverer_profile = $user->delivererProfile()->create($request->only(["area_id", "unique_id", "image", "city_id"]));
            $deliverer_profile->status = 3;
            $deliverer_profile->save();

            if ($request->districts_id) {
                $deliverer_profile->districts()->attach($request->districts_id);
            }

            DB::commit();
            return $this->jsonResponse("Success", $this->deliverTrans->transform($user));
        } catch (\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $deliverer = $this->delivererRepo->getDelivererById($id);

        return $this->jsonResponse("Success", $this->deliverTrans->transform($deliverer));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        // validate request
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "phone" => ["required", Rule::unique("users")->ignore($user->id)],
            "email" => [Rule::unique("users")->ignore($user->id)],
            // "birthdate" => "required|before:" . date("Y-m-d"),
            "role_id" => "required",
            // "unique_id" => "required|unique:deliverer_profiles,unique_id",
            "area_id" => "required|exists:areas,id",
            "city_id" => "required|exists:cities,id"
        ], ["phone.unique" => "This phone number is already registered", "email.unique" => "This email is already registered", "unique_id.unique" => "This unique id is already registered"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        DB::beginTransaction();
        try {
            // store user
            $request->merge(["birthdate" => date("Y-m-d", strtotime($request->birthdate))]);
            $user->update($request->only(["name", "email", "phone", "birthdate"]));
            if ($request->password) {
                $user->password = bcrypt($request->password);
                $user->save();
            }

            $role = Role::find($request->role_id);

            $user->roles()->detach();
            $user->assignRole($role->name);

            $user->addresses->first()->update($request->only(["address"]));

            // store deliverer profile
            $deliverer_profile = $user->delivererProfile;
            $deliverer_profile->update($request->only(["area_id", "unique_id", "image", "city_id"]));

            if ($request->districts_id) {
                $deliverer_profile->districts()->sync($request->districts_id);
            }

            DB::commit();
            return $this->jsonResponse("Success", $this->deliverTrans->transform($user));
        }catch(\Exception $e) {
            DB::rollback();
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
    }

    public function activate($id)
    {
        $deliverer = $this->delivererRepo->getDelivererById($id);

        $deliverer->active = 1;
        $deliverer->deactivation_notes = null;
        $deliverer->save();

        return $this->jsonResponse("Success");
    }

    public function deactivate(Request $request, $id)
    {
        // validate request
        $validator = Validator::make($request->all(), ["deactivation_notes" => "required"]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $deliverer = $this->delivererRepo->getDelivererById($id);

        $deliverer->active = 0;
        $deliverer->deactivation_notes = $request->deactivation_notes;
        $deliverer->save();

        return $this->jsonResponse("Success");
    }

    public function export()
    {
        return Excel::download(new DeliverersExport(), 'Deliverers_' . date("Ymd") . '.xlsx');
    }

    public function import(Request $request)
    {

        $this->validate($request, ["file" => "required"]);
        try {
            $file = $request->file('file');
            $fileName = "Deliverers_" . date("Y_m_d H_i_s") . '.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('public/imports/deliverers', $fileName);
            Excel::import(new DeliverersImport(), $path);
        } catch (\Exception $e) {
            Log::error("Import File Error: " . $e->getMessage());
            return $this->errorResponse($e->getMessage(), "Invalid data", [], 422);
        }
        return $this->jsonResponse("Success");
    }
}
