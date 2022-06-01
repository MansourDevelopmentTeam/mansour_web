<?php

namespace App\Models\Products;

use App\Models\Payment\Promotion\Promotion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $fillable = ["name", "name_ar",'image',"status"];

    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name;
        }
        return $this->name;
    }
    public function promotion()
    {
        return $this->hasOne(Promotion::class);
    }
    public function activePromotion()
    {
        return $this->hasOne(Promotion::class)->where('active',1)->where('expiration_date','>=',Carbon::now());
    }
}
