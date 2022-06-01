<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{
    protected $table = 'customer_request';

    protected $fillable = ['name', 'mobile'];
}
