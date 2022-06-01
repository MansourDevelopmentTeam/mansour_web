<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = 'contact_us';
    protected $fillable = ['name', 'email', 'phone', 'message', 'resolved'];
}
