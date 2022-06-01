<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'amount', 'incentive_id', 'delivered', 'order_id'];
}
