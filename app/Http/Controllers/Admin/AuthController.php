<?php

namespace App\Http\Controllers\Admin;

use App\Mail\ResetAdminPassword;
use App\Mail\ResetPassword;
use App\Models\Users\PasswordReset;
use App\Models\Users\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
    	// validate request
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ], ["email.email" => "Please provide a valiad email"]);
        
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($request->only(["email", "password"]))) {
                return $this->errorResponse("Password or email are incorrect, kindly check them again.", "invalid data", [], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->errorResponse("Password or email are incorrect, kindly check them again.", "invalid data", [], 401);
        }
        
        $user = \Auth::user();

        if(!$user->active) {
            return $this->errorResponse("Your account is deactivated, please contact the support.", "account deactived", [], 401);
        }

        // rare case
        if($user->type != 2){
            return $this->errorResponse("You don't have access to this app", "account deactived", [], 401);   
        }

        $user->token = $token;
        $user->makeHidden(["created_at", "updated_at"]);

        // return success
        return $this->jsonResponse("Success", $user->load("roles.permissions"), 200);
    }

    public function forgetPassword(Request $request)
    {
    	// validate request
        $validator = Validator::make($request->all(), [
            "email" => "required|exists:users,email|email",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "invalid data", $validator->errors(), 422);
        }

        $email = $request->email;

        $user = User::where("email", $email)->get()->first();

        // rare case
        if ($user->type !== 2) {
            return $this->errorResponse("You don't have access to this app", "account deactived", [], 401);   
        }


        // first or create reset token
        $reset = PasswordReset::where("email", $request->email)->get()->first();
        if($reset) {
            $reset->update(["token" => str_random(60)]);
        }else{
            $reset = PasswordReset::create([
                "email" => $user->email,
                "token" => str_random(60)
            ]);
        }

        // send email with the token
        if($user){
            Mail::to($user)->send(new ResetAdminPassword($user, $reset->token));
        }

        return $this->jsonResponse("Success", "A reset link has been sent to your email");
    }

    public function resetPassword(Request $request)
    {
    	// validate request
        $validator = Validator::make($request->all(), [
            "password" => "required",
            "token" => "required"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse("Email is not registered", "invalid data", $validator->errors(), 422);
        }

        $reset = PasswordReset::where("token", $request->token)->get()->first();

        if(!$reset) {
            return $this->errorResponse("Invalid token", "invalid data", $validator->errors(), 422);
        }

        $user = User::where("email", $reset->email)->get()->first();
        $user->password = bcrypt($request->password);
        $user->save();

        $token = JWTAuth::fromUser($user);
        $user->token = $token;

        return $this->jsonResponse("Success", $user);
    }
}
