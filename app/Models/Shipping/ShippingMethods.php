<?php

namespace App\Models\Shipping;

use Illuminate\Database\Eloquent\Model;

class ShippingMethods extends Model
{
    protected $fillable = ["name", 'name_ar'];

	const INTERNAL = 1;
	const MYLERZ = 2;	
	const ARAMEX = 3;	
	const BOSTA = 4;
}
