<?php

namespace App\Models\Repositories;

use App\Models\ACL\Role;
use App\Models\Orders\OrderState;
use App\Models\Users\Affiliates\AffiliateLinkHistory;
use App\Models\Users\Affiliates\AffiliateLinks;
use App\Models\Users\Profile;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AffiliateLinksRepository
{

    public function storeHistory($referral)
    {
        $user = auth()->user();
        $link = AffiliateLinks::where('referral', $referral)->whereDate('expiration_date', '>', now())->first();
        if (!$link) {
            return false;
        }
        $data = [
            'user_ip' => getRealIp(),
            'user_id' => $user->id ?? null,
            'link_id' => $link->id,
        ];
        $histories = $link->histories();
        if ($user){
            $histories->where("user_id", $user->id);
        }else{
            $histories->where("user_ip", getRealIp());
        }
        $history = $histories->first();
        if (!$history){
          $history =  $link->histories()->create($data);
        }
        if ($user){
            $user->update(['link_id'=>$link->id]);
        }
        return $history;
    }

}
