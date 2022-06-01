<?php

namespace App\Models\Branch;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    
    protected $fillable = ["shop_name", "shop_name_ar", "address", "address_ar", "area", "area_ar", "lat", "lng", "phone", "email", "type","order", "direction_link", "images"];

    protected $casts = [
        'phone' => 'array',
        'images' => 'array'
    ];
}
