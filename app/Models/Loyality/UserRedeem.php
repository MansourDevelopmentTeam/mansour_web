<?php

namespace App\Models\Loyality;

use App\Models\Loyality\Reward;
use App\Models\Payment\Promo;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class UserRedeem extends Model
{
    protected $fillable = ["reward_id", "points_used", "status", "promo_id"];

    public function reward()
    {
    	return $this->belongsTo(Reward::class);
    }

    public function promo()
    {
    	return $this->belongsTo(Promo::class);
    }

    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
