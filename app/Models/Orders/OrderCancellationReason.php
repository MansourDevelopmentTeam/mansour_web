<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;

class OrderCancellationReason extends Model
{
    protected $fillable = ["text", "text_ar", "user_type"];
}
