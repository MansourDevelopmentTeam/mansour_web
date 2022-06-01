<?php

namespace App\Models\Users;

use App\Models\Locations\Area;
use App\Models\Locations\City;
use App\Models\Locations\District;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class DelivererProfile extends Model
{

	protected $fillable = ["image", "area_id", "unique_id", "status", "city_id"];

    const AVAILABLE = 1;
    const ONDELIVERY = 2;
    const OFFLINE = 3;

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function districts()
    {
        return $this->belongsToMany(District::class, "deliverer_district", "deliverer_profile_id", "district_id");
    }
    
    public function getImageAttribute()
    {
        if(isset($this->attributes["image"])){
            if(preg_match("/https?:\/\//", $this->attributes["image"])) {
                return $this->attributes["image"];
            }
            return URL::to('') . "/" . $this->attributes["image"];
        }
    }

    public function isAvailable()
    {
        return $this->status == self::AVAILABLE;
    }
}
