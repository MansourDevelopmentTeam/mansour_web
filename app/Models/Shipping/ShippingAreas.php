<?php

namespace App\Models\Shipping;

use Illuminate\Database\Eloquent\Model;

class ShippingAreas extends Model
{
    protected $fillable = [
        "shipping_id",
        "shipping_area_name",
        "shipping_area_code",
        "city_id",
        "area_id",
    ];

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethods::class, 'shipping_id');
    }

    static function getArea($method , $areaId)
    {
        $areaObj = self::whereHas('shippingMethod', function ($methodQuery) use ($method){
            $methodQuery->where('name', $method);
        })->where('area_id', $areaId)
        ->first();

        return $areaObj ? $areaObj->shipping_area_name : '';
    }
}
