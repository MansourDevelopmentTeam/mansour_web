<?php

namespace App\Http\Controllers\Customer;

use App\Facade\Sms;
use App\Rules\PasswordPattern;
use App\Rules\PhoneValid;
use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Models\Users\Address;
use App\Services\SmsServices;
use Illuminate\Validation\Rule;
use App\Models\Users\DeviceToken;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Services\PushService;
use Illuminate\Support\Facades\Lang;
use App\Models\Services\LocationService;
use Illuminate\Support\Facades\Validator;
use App\Notifications\WelcomeNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Transformers\CustomerTransformer;
use App\Http\Resources\Client\UsedPointsResource;
use App\Http\Resources\Client\EarnedPointsResource;
use App\Http\Requests\Customer\ProfileUpdateRequest;
use App\Http\Resources\Client\ExpiredPointsResource;

class ProfileController extends Controller
{
    private $customerTrans;
    private $pushService;
    private $locationService;

    public function __construct(CustomerTransformer $customerTrans, PushService $pushService, LocationService $locationService)
    {
        $this->customerTrans = $customerTrans;
        $this->pushService = $pushService;
        $this->locationService = $locationService;
    }

    public function getProfile()
    {
        $user = auth()->user();
        $user->token = (string)JWTAuth::getToken();
        return $this->jsonResponse("Success", $this->customerTrans->transform($user));
    }

    /**
     * Update profile
     *
     * @param ProfileUpdateRequest $request
     * @return void
     */
    public function editProfile(ProfileUpdateRequest $request)
    {
        $user = User::where("id", "!=", auth()->user()->id)->where('phone', $request->phone)->first();

        if ($user && $user->phone_verified) {
            return $this->errorResponse(Lang::get("mobile.errorPhoneUsed"), "invalid data", [], 422);
        } else if ($user && !$user->phone_verified) {
            $user->phone = null;
            $user->save();
        }

        $user = auth()->user();
        if ($user->phone != $request->phone) {
            $user->phone_verified = 0; // sms code verification code disable
            $user->phone = $request->phone;
            $user->update();
        }
        if ($request->closed_payment_methods) {
            foreach ($request->closed_payment_methods as $method) {
                $user->closedPaymentMethods()->create([
                    'payment_method_id' => $method
                ]);
            }
        }

        $user->update($request->only(["phone", "birthdate", "name", "last_name", "image"]));
        $user->token = (string)JWTAuth::getToken();

        return $this->jsonResponse("Success", $this->customerTrans->transform($user));
    }

    /**
     * Edit phone number
     *
     * @param Request $request
     * @return void
     */
    public function editPhone(Request $request)
    {
        // validate request
        $this->validate($request, [
            "phone" => ["required", "numeric", new PhoneValid()],
        ]);

        $userExists = User::where("id", "!=", auth()->user()->id)->where('phone', $request->phone)->first();
        if ($userExists && $userExists->phone_verified) {
            return $this->errorResponse(trans("mobile.errorPhoneUsed"), "invalid data", [], 422);
        } else if ($userExists && !$userExists->phone_verified) {
            $userExists->phone = null;
            $userExists->save();
        }

        $user = auth()->user();
        
        $code = Sms::send($request->phone);
        $user->verification_code = $code;
        $user->phone_verified = 0;
        $user->phone = $request->phone;
        $user->save();

        $user->token = (string)JWTAuth::getToken();

        return $this->jsonResponse("Success", $this->customerTrans->transform($user));
    }

    public function resendVerification()
    {
        $user = auth()->user();
        if ($user->phone_verified) {
            return $this->errorResponse(Lang::get("mobile.errorPhoneVerified"), "invalid data", [], 422);
        }

        $code = Sms::send($user->phone);
        $user->verification_code = $code;
        $user->phone_verified = 0;
        $user->save();

        $user->token = (string)JWTAuth::getToken();

        return $this->jsonResponse("Success", $this->customerTrans->transform($user));
    }

    public function updateNotificationSettings(Request $request)
    {
        $this->validate($request, [
            "notify_general" => "required"
        ]);

        $user = auth()->user();
        $settings = $user->settings()->firstOrCreate([]);

        $settings->update($request->all());
        $user->token = (string)JWTAuth::getToken();

        return $this->jsonResponse("Success", $this->customerTrans->transform($user));
    }

    public function updateLanguageSettings(Request $request)
    {
        $this->validate($request, [
            "language" => "required"
        ]);

        $user = auth()->user();
        $settings = $user->settings()->firstOrCreate([]);

        $settings->update($request->only('language'));
        $user->token = (string)JWTAuth::getToken();

        return $this->jsonResponse("Success", $this->customerTrans->transform($user));
    }

    public function changePassword(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "old_password" => "required",
            "password" => ["required", "min:8", new PasswordPattern()]
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $user = auth()->user();

        if (!\Auth::attempt(["phone" => $user->phone, "password" => $request->old_password])) {
            return $this->errorResponse(trans('mobile.errorIncorrectOldPassword'), "invalid data", [], 403);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return $this->jsonResponse("Success");
    }

    /**
     * Undocumented function
     *
     * @deprecated v1.0
     * @param Request $request
     * @return void
     */
    public function verifyPhone(Request $request)
    {
        // DEPRECATED
        $this->validate($request, [
            "code" => "required"
        ]);

        $user = auth()->user();
        if ($user->verification_code != $request->code) {
            return $this->errorResponse(trans('mobile.errorIncorrectVerification'), "Invalid data", [], 422);
        }

        $user->phone_verified = 1;
        $user->verification_code = null;
        $user->save();

        return $this->jsonResponse(trans("mobile.success"));
    }

    public function getPointHistory(Request $request)
    {
        $user = auth()->user();
        $earned = $user->points;
        $used = $user->redeems;

        // group by expiration date and sum expired points
        $expired = $user->points()
            ->select("*", DB::raw("SUM(expired_points) as expirations"))
            ->groupBy(DB::raw("DATE(expiration_date)"))
            ->where("expiration_date", "<=", now())->get();

        // dd($expired);

        return $this->jsonResponse("Success", [
            "earned" => EarnedPointsResource::collection($earned),
            "used" => UsedPointsResource::collection($used),
            "expired" => ExpiredPointsResource::collection($expired)
        ]);
    }

    public function addToken(Request $request)
    {
        // validate request
        $validator = Validator::make($request->all(), [
            "token" => "required",
            "device_type" => "in:1,2"
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), "Invalid data", $validator->errors(), 422);
        }

        $user = auth()->user();

        $token_count = $user->tokens->count();

        // check if token exist
        Log::info("TOKEN API " . $request->token);
        if (DeviceToken::where("token", $request->token)->exists()) {
            Log::info("TOKEN EXIST");
            DeviceToken::where("token", $request->token)->delete();
        }

        $token = $user->tokens()->create(["token" => $request->token, "device" => $request->device_type]);

        if (!$token_count)
            Notification::send($user, new WelcomeNotification());

        return $this->jsonResponse("Success", $token_count);
    }

    /**
     * Check if user has a phone and verified
     *
     * @param \Illuminate\Http\Request $request
     */
    public function checkPhoneVerified(Request $request)
    {
        $user = auth()->user();

        if (!$user->phone) {
            return $this->errorResponse(trans("mobile.user_has_invalid_phone"), "invalid data", [], 410);
        }

        if ($user->phone_verified) {
            return $this->errorResponse(trans("mobile.errorPhoneVerified"), "invalid data", [], 411);
        }

        $smsServices = new SmsServices;
        $error = $smsServices->checkPhoneVerified($user);
        
        if ($error) {
            return $this->errorResponse($error, "invalid data", [], 409);
        }
        
        return $this->jsonResponse(trans("mobile.phone_verified_successfully"), $this->customerTrans->transform($user));
    }
}
