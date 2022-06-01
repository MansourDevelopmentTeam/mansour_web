<?php

namespace App\Models\Locations;

use App\Models\Shipping\ShippingAreas;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    
    protected $fillable = ["name", "name_ar", "city_id", "active", "delivery_fees","aramex_area_name", "delivery_fees_type"];
    protected $hidden = ["created_at", "updated_at"];

    protected $casts = [
    	"active" => "boolean"
    ];

    public function city()
    {
    	return $this->belongsTo(City::class);
    }

    public function districts()
    {
    	return $this->hasMany(District::class)->orderBy("name", "ASC");
    }
    public function activeDistricts()
    {
        return $this->hasMany(District::class)->orderBy("name", "ASC");
    }
    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name;
        }
        return $this->name;
    }
}
