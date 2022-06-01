<?php

namespace App\Models\Users\Affiliates;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class AffiliateLinkHistory extends Model
{
    protected $fillable = [
        'user_ip',
        'user_id',
        'link_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
    public function link()
    {
        return $this->belongsTo(AffiliateLinks::class, "link_id");
    }
}
