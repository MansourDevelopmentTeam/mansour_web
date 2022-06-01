<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

	protected $fillable = ["name", "name_ar", "delivery_fees", "active", "deactivation_notes", "delivery_fees_type"];
	protected $hidden = ["created_at", "updated_at"];
    
    public function areas()
    {
    	return $this->hasMany(Area::class)->orderBy("name", "ASC");
    }
    public function activeAreas()
    {
        return $this->hasMany(Area::class)->orderBy("name", "ASC")->where('active',1);
    }

    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name;
        }
        return $this->name;
    }
}
