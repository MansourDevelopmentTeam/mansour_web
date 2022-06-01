<?php

namespace App\Models\Repositories;

use App\Models\ACL\Role;
use App\Models\Orders\OrderState;
use App\Models\Users\Profile;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Social repo
 */
class AffiliateRepository
{

    public function createAffiliateLink($affiliate, $url)
    {
        $siteUrl = config('app.website_url');
        $requestedUrl = $url;
        $siteUrl = str_replace('www.', '', $siteUrl);
        $requestedUrl = str_replace('www.', '', $requestedUrl);
        $requestedUrlWithHTTP = str_replace('www.', '', 'https://' . $url);
        $parsedSitedUrl = parse_url($siteUrl);
        $parsedRequestedUrl = parse_url($requestedUrl);
        $referral =  Str::random(20);
        $referralQueryParam = 'referral='.$referral;


        // ?referral=' .$this->referral

        !isset($parsedRequestedUrl['scheme']) ? $parsedRequestedUrl = parse_url($requestedUrlWithHTTP) : '';
        if (isset($parsedRequestedUrl['scheme']) && isset($parsedRequestedUrl['host']) && isset($parsedSitedUrl['host']) && $parsedSitedUrl['host'] == $parsedRequestedUrl['host']) {
            $path = isset($parsedRequestedUrl['path']) ? $parsedRequestedUrl['path'] : null;
            $query = isset($parsedRequestedUrl['query']) ? '?'.$parsedRequestedUrl['query']  . '&'.$referralQueryParam : '?'.$referralQueryParam;
            $data['url'] = 'https://www.' . $parsedRequestedUrl['host'] . $path .$query ;
        } else {
            return false;
        }
        $data['referral'] =$referral;
        $data['expiration_date'] = Carbon::parse()->now()->addDays(30);
        $link = $affiliate->affiliateLinks()->create($data);
        return $link;
    }

}
