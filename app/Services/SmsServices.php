<?php

namespace App\Services;

use App\Facade\Sms;
use App\Models\Users\Address;

/**
 * SmsServices class
 *
 * @package  App\Services
 */
class SmsServices
{

    /**
     * Check if the user has a phone verified
     *
     * @param \App\Models\Users\User $user
     * @return string|null
     */
    public function checkPhoneVerified($user = null)
    {
        $error = null;
        $user = $user ?? auth()->user();

        if ($user && $user->id != 999999) {
            $error = $this->checkPhoneVerifiedForAuthUser($user);
        } else {
            $error = $this->checkPhoneVerifiedForGuestUser();
        }

        return $error;
    }

    /**
     * Check if the authicated user has a phone verified
     *
     * @return string|null
     */
    private function checkPhoneVerifiedForAuthUser($user)
    {
        $error = null;

        if (!$user->phone) {
            return trans('mobile.user_has_invalid_phone');
        }

        if ($user->phone_verified) {
            return null;
        }

        if (request()->has('verification_code') && request()->get('verification_code') != "") {
            $success = Sms::verify($user->phone, $user->verification_code);
            if ($success) {
                $user->phone_verified = 1;
                $user->verification_code = null;
                $user->save();
            } else {
                $error = trans('mobile.errorIncorrectVerification');
            }
        } else {
            $code = Sms::send($user->phone);
            $user->verification_code = $code;
            $user->save();
            $error = trans('mobile.errorUpdateApp');
        }

        return $error;
    }

    /**
     * Check if the guest user has address with phone verified
     *
     * @return string|null
     */
    private function checkPhoneVerifiedForGuestUser()
    {
        $guest = Address::whereNull('user_id')->where('id', request()->get('address_id'))->firstOrFail();
        $error = null;
        if (!$guest->phone) {
            return trans('mobile.user_has_invalid_phone');
        }

        if ($guest->phone_verified) {
            return null;
        }


        if (request()->get('verification_code')) {
            $success = Sms::verify($guest->phone, $guest->verification_code);

            if ($success) {
                $guest->phone_verified = 1;
                $guest->verification_code = null;
                $guest->save();
            } else {
                $error = trans('mobile.errorIncorrectVerification');
            }
        } else {
            $code = Sms::send($guest->phone);
            $guest->verification_code = $code;
            $guest->save();
            $error = trans('mobile.errorUpdateApp');
        }

        return $error;
    }
}
