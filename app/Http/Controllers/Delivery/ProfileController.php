<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Orders\OrderManager;
use App\Models\Repositories\OrderRepository;
use App\Models\Services\PushService;
use App\Models\Users\DelivererProfile;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    private $ordersRepo;
    private $notificationsService;

    public function __construct(OrderRepository $ordersRepo, PushService $notificationsService)
    {
        $this->ordersRepo = $ordersRepo;
        $this->notificationsService = $notificationsService;
    }

    
    public function getStatus()
    {
    	$user = \Auth::user();

    	return $this->jsonResponse("Success", ["status" => $user->delivererProfile->status]);
    }

    public function changeStatus(Request $request)
    {
    	// validate request
    	$validator = Validator::make($request->all(), [
    		"status" => "required|in:1,2,3"
    	]);
    	
    	if ($validator->fails()) {
    	    return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
    	}

    	$user = \Auth::user();
    	$user->changeStatus($request->status);

        if($request->status == DelivererProfile::ONDELIVERY) {
            // change all his orders to on delivery
            $orders = $this->ordersRepo->getDelivererPreparedOrders($user);

            OrderManager::setOrdersOnDelivery($orders);
        }

    	return $this->jsonResponse("Success", ["status" => $request->status]);
    }

    public function addToken(Request $request)
    {
        // validate
        $validator = Validator::make($request->all(), [
            "token" => "required",
            // "device" => "required",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse("Invalid Data", "invalid data", $validator->errors(), 422);
        }

        $user = \Auth::user();

        $token = $user->tokens()->where("token", $request->token)->get();
        
        if(!$token->count()){
            $user->tokens()->create([
                "token" => $request->token,
                "device" => $request->device
            ]);
        }

        return $this->jsonResponse("Success", true);
    }

    public function testPush($id)
    {
        $user = User::find($id);
        $this->notificationsService->notify($user, "This is from El-Dokan", "this is body");

        return $this->jsonResponse("Success", true);
    }
}
