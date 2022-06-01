<?php

namespace App\Models\Payment\Promotion;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class PromotionUser extends Model
{

    protected $fillable = [
        'promotion_id',
        'user_id',
        'use_date',
        'valid_date',
        'order_id',
    ];

}
