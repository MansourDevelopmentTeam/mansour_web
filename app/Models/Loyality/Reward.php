<?php

namespace App\Models\Loyality;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    // Type reward
    const TYPE_PROMO = 1;
    const TYPE_GIFT = 2;
    // Amount Type of promo
    const AMOUNT_TYPE_AMOUNT = 1;
    const AMOUNT_TYPE_PERCENT = 2;
    const AMOUNT_TYPE_FREE_DELIVERY = 3;

    protected $fillable = ["name", "name_ar", "description", "description_ar", "type", "image", "is_gold", "amount_type", "amount", "max_amount", "point_cost"];
    
    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name;
        }

        return $this->name;
    }

    public function getDescription($lang = 1)
    {
        if ($lang == 2) {
            return $this->description_ar ?: $this->description;
        }

        return $this->description;
    }
}
