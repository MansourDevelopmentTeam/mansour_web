<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class AffiliateLinksResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'referral' => $this->referral,
            'affiliate_id' => $this->affiliate_id,
            'expiration_date' => (string)$this->expiration_date,
            'affiliate' => $this->affiliate,
            'history_count' => $this->histories->count(),
            'created_at' => (string)$this->created_at,
        ];
    }
}
