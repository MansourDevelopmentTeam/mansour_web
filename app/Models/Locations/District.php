<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ["name", "name_ar", "area_id", "active", "delivery_fees", "delivery_fees_type"];

    public function area()
    {
    	return $this->belongsTo(Area::class);
    }

    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name;
        }
        return $this->name;
    }
}
