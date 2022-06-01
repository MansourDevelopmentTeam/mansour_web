<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = ['notify_general', 'language'];
}
