<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Transformers\DelivererTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    private $delivererTrans;

    public function __construct(DelivererTransformer $delivererTrans)
    {
        $this->delivererTrans = $delivererTrans;
    }

    
    public function login(Request $request)
    {
    	// validate request
    	$validator = Validator::make($request->all(), [
    		"phone" => "required",
    		"password" => "required"
    	]);
    	
    	if ($validator->fails()) {
    	    return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
    	}

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($request->only(["phone", "password"]))) {
                return $this->errorResponse("رقم الهاتف او كلمة السر غير صحيح, برجاء اعادة المحاولة.", "invalid data", [], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->errorResponse("رقم الهاتف او كلمة السر غير صحيح, برجاء اعادة المحاولة.", "invalid data", [], 401);
        }
        
        $user = \Auth::user();

        if(!$user->active) {
            return $this->errorResponse("حسابك غير مفعل برجاء التواصل مع الادارة", "account deactived", [], 401);
        }

        if(!$user->delivererProfile || !$user->type !== 3) {
            throw new \Exception("This user does not have a delivery profile", 1);
        }


        $user->token = $token;
        $user->makeHidden(["created_at", "updated_at"]);

        // return success
        return $this->jsonResponse("Success", $this->delivererTrans->transform($user), 200);
    }
}
