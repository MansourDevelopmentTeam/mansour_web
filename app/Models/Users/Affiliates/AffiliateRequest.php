<?php

namespace App\Models\Users\Affiliates;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class AffiliateRequest extends Model
{
    protected $fillable = [
        'name',
        'last_name',
        'password',
        'email',
        'image',
        'phone',
        'phone_verified',
        'verification_code',
        'birthdate',
        'status',
        'user_id',
        'rejection_reason',
    ];
    protected $hidden = [
        'password'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
