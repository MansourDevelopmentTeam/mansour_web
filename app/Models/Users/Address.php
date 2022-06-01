<?php

namespace App\Models\Users;

use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    public static $validation = [
        'name' => 'required',
        'city_id' => 'required|exists:cities,id',
        'area_id' => 'required|exists:areas,id',
        'address' => 'required',
        'apartment' => 'required',
        'floor' => 'required',
    ];
    protected $hidden = ['created_at', 'updated_at'];
    protected $fillable = ['name','user_id', 'customer_first_name', 'customer_last_name', 'city_id', 'area_id', 'district_id', 'address', 'apartment', 'floor', 'landmark', 'primary', 'lat', 'lng',"phone","email","verification_code","phone_verified"];

    protected $appends = ['formatted_address'];

    protected $casts = [
        'primary' => 'boolean',
        'phone_verified' => 'boolean'
    ];

    public function getFormattedAddressAttribute()
    {
        $formatted = "مبني {$this->floor}, شارع {$this->address}, شقة {$this->apartment}";

        if ($this->landmark) {
            $formatted = $formatted.', '.$this->landmark;
        }

        return $formatted.($this->district ? (', '.$this->district->name) : '').($this->area ? (', '.$this->area->name_ar) : '').', '.($this->city ? $this->city->name_ar : '');
    }

    public function getAramexAddress()
    {
        $areaName = $this->area ? (', '.$this->area->name_ar) : '';
        $cityName = $this->city ? $this->city->name_ar : '';
        $formatted = "مبني {$this->floor}, شارع {$this->address}, شقة {$this->apartment}";

        if ($this->landmark) {
            $formatted = $formatted.', علامة مميزة: '.$this->landmark;
        }

        return $formatted.", {$areaName}, {$cityName}";
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function format()
    {
        return $this->address;
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getCustomerFullNameAttribute()
    {
        return "{$this->customer_first_name} {$this->customer_last_name}";
    }
    /**
     * Set the user's phone verified.
     *
     * @param  string  $value
     * @return void
     */
   public function setPhoneVerifiedAttribute($value)
   {
       if(config('integrations.sms.default') == ""){
           $value = 1;
       }
       $this->attributes['phone_verified'] = $value;
   }
}
