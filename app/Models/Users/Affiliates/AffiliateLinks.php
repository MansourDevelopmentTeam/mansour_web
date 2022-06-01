<?php

namespace App\Models\Users\Affiliates;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class AffiliateLinks extends Model
{
    protected $fillable = [
        'url',
        'referral',
        'affiliate_id',
        'expiration_date'
    ];

    public function affiliate()
    {
        return $this->belongsTo(User::class, "affiliate_id");
    }
    public function histories()
    {
        return $this->hasMany(AffiliateLinkHistory::class, "link_id");
    }
}
