<?php

namespace App\Models\Payment;

use App\Models\Orders\Order;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected $fillable = ["total_amount", "cost_amount", "discount", "remaining", "paid_amount", "delivery_fees", "admin_discount", "grand_total","total_delivery_fees","free_delivery","promo_id"];
    
    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function promo()
    {
    	return $this->belongsTo(Promo::class);
    }

    public function hasPromo()
    {
    	return (bool)$this->promo;
    }

    public function getCostAmountAttribute()
    {
        return $this->attributes["cost_amount"] / 100;
    }

    public function setCostAmountAttribute($value)
    {
        $this->attributes["cost_amount"] = $value * 100;
    }

    public function getTotalAmountAttribute()
    {
        return $this->attributes["total_amount"] / 100;
    }

    public function setTotalAmountAttribute($value)
    {
        $this->attributes["total_amount"] = $value * 100;
    }

    public function getDiscountAttribute()
    {
        if (isset($this->attributes["discount"]) && !is_null($this->attributes["discount"]))
            return $this->attributes["discount"] / 100;
    }

    public function setDiscountAttribute($value)
    {
        if($value == 0){
            $this->attributes["discount"] = null;
        }else{
            $this->attributes["discount"] = $value * 100;
        }
    }

    public function getPaidAmountAttribute()
    {
        return $this->attributes["paid_amount"] / 100;
    }

    public function setPaidAmountAttribute($value)
    {
        $this->attributes["paid_amount"] = $value * 100;
    }

    public function getRemainingAttribute()
    {
        return $this->attributes["remaining"] / 100;
    }

    public function setRemainingAttribute($value)
    {
        $this->attributes["remaining"] = $value * 100;
    }
}
