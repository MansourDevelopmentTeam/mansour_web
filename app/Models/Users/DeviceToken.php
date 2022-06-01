<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $fillable = ["token", "user_id", "device"];

    const ADNROID = 1;
    const IOS = 2;

}
