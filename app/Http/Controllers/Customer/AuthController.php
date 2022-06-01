<?php

namespace App\Http\Controllers\Customer;

use App\Jobs\SendSMSViaOrange;
use App\Models\Users\User;
use App\Mail\ResetPassword;
use App\Rules\PhoneValid;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Mail\NewRegistration;
use App\Models\Users\ContactUs;
use App\Mail\ResetUserPasswordV2;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Users\PasswordReset;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Spatie\Newsletter\NewsletterFacade;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Repositories\SocialRepository;
use App\Models\Transformers\CustomerTransformer;

class AuthController extends Controller
{
    private $customerTrans;
    private $socialRepo;

    /**
     * Constructor
     *
     * @param CustomerTransformer $customerTrans
     * @param SocialRepository $socialRepo
     */
    public function __construct(CustomerTransformer $customerTrans, SocialRepository $socialRepo)
    {
        $this->customerTrans = $customerTrans;
        $this->socialRepo = $socialRepo;
    }
    /**
     * Login customer api
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "phone" => "required|string",
            "password" => "required|string",
        ]);
        
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        try {
            // attempt to verify the credentials with phone and create a token for the user
            $message = Lang::get('mobile.errorIncorrectPhone');
            $token = JWTAuth::attempt($request->only(["phone", "password"]));
            
            if (!$token) {
                return $this->errorResponse($message, "invalid data", [], 403);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return $this->errorResponse($message, "invalid data", [], 403);
        }
     
        $user = \Auth::user();

        if ($user->type !== 1) {
            return $this->errorResponse(Lang::get("mobile.noAccess"), "invalid data", [], 403);
        }

        if (!$user->active) {
            return $this->errorResponse(Lang::get("mobile.errorAccountDeactivated"), "account deactived", [], 403);
        }

        $user->token = $token;
        $user->makeHidden(["created_at", "updated_at"]);

        // return success
        return $this->jsonResponse("Success", $this->customerTrans->transform($user), 200);
    }

    public function logout(Request $request)
    {
        try {
            // and you can continue to chain methods
            $user = JWTAuth::parseToken()->authenticate();

            // $validator = Validator::make($request->all(), [
            //     "token" => "required"
            // ]);
            
            // if ($validator->fails()) {
            //     return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
            // }

            if ($user)
                $user->tokens()->where("token", $request->token)->delete();
        } catch (\Exception $e) {
            
        }

        return $this->jsonResponse("Success");
    }

    public function guest()
    {
        $guest = User::find(999999);

        $token = JWTAuth::fromUser($guest);
        // $guest->token = $token;
        $guest->token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL21vYmlsYXR5YXBpLmVsLWRva2FuLmNvbS9hcGkvY3VzdG9tZXIvYXV0aC9ndWVzdCIsImlhdCI6MTYxMjgxNDExNiwiZXhwIjozNzYxMjgxNDExNiwibmJmIjoxNjEyODE0MTE2LCJqdGkiOiJucGRzYVpJdnV5Mm1PM2NQIiwic3ViIjo5OTk5OTksInBydiI6IjRhYzA1YzBmOGFjMDhmMzY0Y2I0ZDAzZmI4ZTFmNjMxZmVjMzIyZTgifQ.BkXuKfrX6TjyA0UJrd0h3Z_CCL0GXRA_M3-cBAyfWgA";


        return $this->jsonResponse("Success", $this->customerTrans->transform($guest));
    }

    public function register(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "name" => "required|min:3",
            "last_name" => "required|min:3",
            "email" => "required|unique:users,email|email",
            "birthdate" => "nullable|before:" . date("Y-m-d"),
            "password" => "required|min:8",
            "phone" => ["required", "numeric", new PhoneValid()],
        ], ["email.unique" => trans("mobile.errorEmailUsed"), "name.min" => trans("mobile.errorNameMin")]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "invalid data", $validator->errors(), 422);
        }

        $user = User::where('phone', $request->phone)->first();
        if ($user && $user->phone_verified) {
            return $this->errorResponse(trans("mobile.errorPhoneUsed"), "invalid data", $validator->errors(), 422);
        } else if ($user && !$user->phone_verified) {
            $user->phone = null;
            $user->save();
        }

        // register a user
        $user = User::create($request->all());
        $user->password = bcrypt($request->password);
        $user->active = 1;
        $user->phone_verified = 0;
        $user->type = 1;
        $user->save();

        $settings = $user->settings()->firstOrCreate(['language' => $request->header('lang', 1) == 2 ? "ar" : "en"]);

        if (!$user->referal) {
            $user->referal = $user->generateReferal();
            $user->save();
        }

        $token = JWTAuth::attempt($request->only(["email", "password"]));
        $user->token = $token;
        $user->makeHidden(["created_at", "updated_at", "verification_code"]);

        if (!app()->environment('local')) {
            Mail::to($user)->send(new NewRegistration($user));
        }

        // return success
        return $this->jsonResponse("Success", $this->customerTrans->transform($user), 200);
    }

    public function socialRegister(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "name" => "required|min:3",
            "birthdate" => "nullable|before:" . date("Y-m-d"),
            // "phone" => "required|unique:users,phone|min:11",
            "token" => "required"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "invalid data", $validator->errors(), 422);
        }

        $user = User::where('phone', $request->phone)->first();

        if($user){

            if($user->phone_verified){
                return $this->errorResponse(Lang::get("mobile.errorPhoneUsed"), "invalid data", $validator->errors(), 422);
            }
            $user->phone = null;
            $user->save();
        }

        // Work around for iOS ... take 2 ... go to hell ya sameh
        JWTAuth::setToken($request->token);

        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['user_not_found'], 404);
        }
        if (!$user->active) {
            return $this->errorResponse(Lang::get("mobile.errorAccountDeactivated"), "account deactived", [], 403);
        }

        // register a user
        // $user = \Auth::user();
        $request->merge(["type" => 1]);
        $user->update($request->only(["name", "last_name", "birthdate", "phone", "type"]));


        $user->token = (string)JWTAuth::getToken();
        $user->makeHidden(["created_at", "updated_at"]);
        Mail::to($user)->send(new NewRegistration($user));
        // return success
        return $this->jsonResponse("Success", $this->customerTrans->transform($user), 200);
    }

    public function socialAuth(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "provider" => "required|in:facebook,google,apple"
        ]);
        
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }
        $token = $request->access_token;
        $provider = $request->provider;
        if ($provider == "google") {
            try {
                // $request->merge(['code' => $request->access_token]);
                if ($request->code) {
                    $providerUser = Socialite::driver($provider)->stateless()->user();
                } else {
                    $providerUser = Socialite::driver($provider)->stateless()->userFromToken($request->access_token);
                }
            } catch (\Exception $e) {
                return $this->errorResponse("Provider Error", "Invalid token", $e->getMessage(), 400);
            }
        } else if ($provider == "facebook") {
            try {
                $providerUser = Socialite::driver($provider)->stateless()->userFromToken($token);
            } catch (\Exception $e) {
                return $this->errorResponse("Provider Error", "Invalid token", $e->getMessage(), 400);
            }
        } else if ($provider == "apple") {
            //  $providerUser = Socialite::driver($provider)->stateless()->user();
            $providerUser = Socialite::driver($provider)->stateless()->userFromToken($token);
            if ($request->name) {
                $providerUser->name = $request->name;
            } else {
                $providerUser->name = "";
            }
        }
        // dd($providerUser);
        $registered = $this->socialRepo->isFirst($provider, $providerUser->id);
        $user = $this->socialRepo->firstOrCreate($providerUser, $provider);
        if (!$user->referal) {
            $user->referal = $user->generateReferal();
            $user->save();
        }

        $settings = $user->settings()->firstOrCreate(['language' => 'en']);
        
        $token = \JWTAuth::fromUser($user);
        $user->token = $token;
        $user->makeHidden(["created_at", "updated_at"]);
        if (!$user->active) {
            return $this->errorResponse(Lang::get("mobile.errorAccountDeactivated"), "account deactived", [], 403);
        }
        return $this->jsonResponse("Success", $this->customerTrans->transform($user), 200);
    }

    public function forgetPassword(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "phone" => "required|exists:users,phone",
        ], [
            "phone.exists" => Lang::get("mobile.errorPhoneNotFound")
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(),
                "invalid data", $validator->errors(), 422);
        }

        $phone = $request->phone;

        $user = User::where("phone", $phone)->get()->first();
        try {
            $password = random_int(10000000, 99999999);
        } catch (\Exception $exception) {
            $password = 357792; //default password
        }
        $message = __('reset_password_message', ['password' => $password]);
        $user->update([
            'password' => bcrypt($password)
        ]);
        try {
            SendSMSViaOrange::dispatch($phone, $message);
        } catch (\Exception $exception) {
            Log::channel('orange_sms')->info('Error sending sms to phone : ' . $phone);
        }

        // first or create reset token
//        $reset = PasswordReset::where("phone", $request->phone)->get()->first();

//        $token = 12345; // rand(10000, 99999)

//        if ($reset) {
//            $reset->update(["token" => $token]);
//        } else {
//            $reset = PasswordReset::create([
//                "phone" => $user->phone,
//                "token" => $token
//            ]);
//        }

        // send email/sms with the token
//        if ($user) {
//            Mail::to($user)->send(new ResetPassword($user, $reset->token));
//        }

        return $this->jsonResponse(__("mobile.new_password_sent_via_sms"));
    }

    public function validateCode(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "phone" => "required|exists:users,phone",
            "code" => "required|exists:password_resets,token",
        ], ["code.exists" => Lang::get("mobile.errorIncorrectCode")]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(),
                "invalid data", $validator->errors(), 422);
        }

        if (!PasswordReset::where("phone", $request->phone)->where("token", $request->code)->get()->count())
            return $this->errorResponse(Lang::get("mobile.errorIncorrectCode"), "Incorrect Code", [], 403);

        return $this->jsonResponse("Success");
    }

    public function resetPassword(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "phone" => "required|exists:users,phone",
            "code" => "required|exists:password_resets,token",
            "password" => "required",
        ], ["code.exists" => Lang::get("mobile.errorIncorrectCode")]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(),
                "invalid data", $validator->errors(), 422);
        }

        $reset = PasswordReset::where("token", $request->code)->get()->first();

        if (!$reset) {
            return $this->errorResponse(Lang::get("mobile.errorIncorrectCode"),
                "invalid data", $validator->errors(), 422);
        }

        $user = User::where("phone", $reset->phone)->get()->first();
        $user->password = bcrypt($request->password);
        $user->save();

        $token = JWTAuth::fromUser($user);
        $user->token = $token;

        return $this->jsonResponse("Success", $this->customerTrans->transform($user));
    }

    public function subscribeNewsletter(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email"
        ]);

        NewsletterFacade::subscribe($request->email);

        return $this->jsonResponse("Success");
    }

    public function contactUs(Request $request)
    {
        $this->validate($request, [
            "name" => "required",
            "email" => "required|email",
            "phone" => "required",
            "message" => "required",
        ]);

        $contact = ContactUs::create($request->all());

        return $this->jsonResponse(trans('message.success'), $contact);
    }

    public function forgetPasswordV2(Request $request)
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
        if ($user->type !== 1) {
            return $this->errorResponse("You don't have access to this app", "account deactived", [], 401);
        }


        // first or create reset token
        // $reset = PasswordReset::where("email", $request->email)->first();
        // if($reset) {
        //     $reset->update(["token" => str_random(60)]);
        // }else{
        //     $reset = PasswordReset::create([
        //         "email" => $user->email,
        //         "token" => str_random(60)
        //     ]);
        // }
        $reset = PasswordReset::create([
            "email" => $user->email,
            "token" => Str::random(60)
        ]);
        // send email with the token
        if($user){
            Mail::to($user)->send(new ResetUserPasswordV2($user, $reset->token));
        }

        return $this->jsonResponse("Success", "A reset link has been sent to your email");
    }

    public function resetPasswordV2(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "password" => "required",
            "token" => "required"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse("invalid data", "invalid data", $validator->errors(), 422);
        }
        $reset = PasswordReset::where("token", $request->token)->where('created_at','>', now()->subHours(2))->first();

        if(!$reset) {
            return $this->errorResponse(trans('mobile.linkUsedBefore'), "invalid data", $validator->errors(), 422);
        }
        $user = User::where("email", $reset->email)->get()->first();
        $user->password = bcrypt($request->password);
        $user->save();
        $token = JWTAuth::fromUser($user);
        $user->token = $token;
        $reset->delete();
        return $this->jsonResponse("Success", $user);
    }

    public function forgetPasswordWithPhone(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "phone" => "required|exists:users,phone|string",
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "invalid data", $validator->errors(), 422);
        }

        $phone = $request->phone;

        $user = User::where("phone", $phone)->get()->first();

        // rare case
        if ($user->type !== 1) {
            return $this->errorResponse("You don't have access to this app", "account deactived", [], 401);
        }

        $reset = PasswordReset::create([
            "email" => $user->phone,
            "token" => bin2hex(Str::random(5))
        ]);
        // send email with the token
        if($user){
            // Mail::to($user)->send(new ResetUserPasswordV2($user, $reset->token));
        }

        return $this->jsonResponse("Success", "A reset code has been sent to your phone");
    }

    public function resetPasswordWithPhone(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "password" => "required",
            "token" => "required"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse("invalid data", "invalid data", $validator->errors(), 422);
        }
        $reset = PasswordReset::where("token", $request->token)->where('created_at','>', now()->subHours(2))->first();

        if(!$reset) {
            return $this->errorResponse(trans('mobile.linkUsedBefore'), "invalid data", $validator->errors(), 422);
        }
        $user = User::where("phone", $reset->email)->get()->first();
        $user->password = bcrypt($request->password);
        $user->save();
        $token = JWTAuth::fromUser($user);
        $user->token = $token;
        $reset->delete();
        return $this->jsonResponse("Success", $user);
    }

    public function validateCodeWithPhone(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "phone" => "required|exists:users,phone|string",
            "code" => "required|exists:password_resets,token",
        ], ["code.exists" => Lang::get("mobile.errorIncorrectCode")]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "invalid data", $validator->errors(), 422);
        }

        if (!PasswordReset::where("email", $request->phone)->where("token", $request->code)->get()->count()) {
            return $this->errorResponse(Lang::get("mobile.errorIncorrectCode"), "Incorrect Code", [], 403);
        }

        return $this->jsonResponse("Success");
    }
}
