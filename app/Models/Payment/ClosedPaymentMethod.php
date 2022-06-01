<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class ClosedPaymentMethod extends Model
{
    protected $fillable = ['user_id', 'payment_method_id'];
}
