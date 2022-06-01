<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class PaymentCredential extends Model
{
    protected $fillable = ['method_id', 'name', 'value', 'default'];
}
