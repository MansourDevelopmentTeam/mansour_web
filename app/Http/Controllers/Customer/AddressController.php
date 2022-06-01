<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Models\Users\Address;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\Services\LocationService;
use App\Http\Requests\Customer\AddressRequest;
use App\Models\Transformers\CustomerTransformer;

class AddressController extends Controller
{
    private $locationService;
    private $customerTrans;

    public function __construct(CustomerTransformer $customerTrans, LocationService $locationService)
    {
        $this->locationService = $locationService;
        $this->customerTrans = $customerTrans;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Customer\AddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
        $data = $request->validated();
        
        $data['phone_verified'] = 0;
        $data['primary'] = isset($data['primary']) ? $data['primary'] : 0;
        
        if (!$this->locationService->isLastNode($request->city_id, $request->area_id, $request->district_id)) {
            return $this->errorResponse(trans('mobile.errorInvalidAddress'), "Invalid data", [], 422);
        }
        
        $user = auth()->user();
        if (auth()->check()) {
            $data['user_id'] = $user->id;
            $data['customer_first_name'] = $user->name;
            $data['customer_last_name'] = $user->last_name;
            if ($request->primary) {
                $user->addresses()->update(["primary" => 0]);
            }
        } else {
            $data['customer_first_name'] = $request->get('CustomerFirstName');
            $data['customer_last_name'] = $request->get('CustomerLastName');
        }
        
        $address = Address::create($data);
        if (auth()->check()) {
            $user->token = (string) JWTAuth::getToken();
            return $this->jsonResponse("Success", $this->customerTrans->transform($user->load("addresses")));
        }
        return $this->jsonResponse("Success", $address);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Customer\AddressRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, $id)
    {
        if (!$this->locationService->isLastNode($request->city_id, $request->area_id, $request->district_id)) {
            return $this->errorResponse(trans('mobile.errorInvalidAddress'), "Invalid data", [], 422);
        }

        $user = auth()->user();
        $address = Address::where('user_id', $user->id)->where('id', $id)->first();
        $data = $request->validated();

        $new_address = $address->replicate();
        $new_address->created_at = $address->created_at;
        $new_address->save();

        if (!$request->area_id) {
            $request->merge(["area_id" => null]);
        }
        if (!$request->district_id) {
            $request->merge(["district_id" => null]);
        }

        $user_details = [
            'customer_first_name' => $user->name,
            'customer_last_name' => $user->last_name,
            'phone' => $user->phone,
            'email' => $user->email
        ];
        $data = array_merge($data, $user_details);

        $new_address->update($data);

        if ($request->primary === true) {
            $user_details['primary'] = 0;
            Address::where('user_id', $user->id)->where('id', '!=', $address->id)->update($user_details);
            $new_address->primary = 1;
            $new_address->save();
        }

        $address->delete();

        $user->refresh();
        $user->token = (string) JWTAuth::getToken();

        return $this->jsonResponse("Success", $this->customerTrans->transform($user->load("addresses")));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $address = Address::where('user_id', $user->id)->where('id', $id)->first();

        $address->delete();
        $user->token = (string)JWTAuth::getToken();

        return $this->jsonResponse("Success", $this->customerTrans->transform($user->load("addresses")));
    }

    /**
     * Set primary address
     *
     * @param int $id
     * @return void
     */
    public function setPrimaryAddress($id)
    {
        $user = auth()->user();
        $address = Address::where('user_id', $user->id)->where('id', $id)->first();

        $user->addresses()->update(["primary" => 0]);
        $address->update(["primary" => 1]);

        $user->token = (string) JWTAuth::getToken();

        return $this->jsonResponse("Success", $this->customerTrans->transform($user->load("addresses")));
    }
}
