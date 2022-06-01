<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
	protected $fillable = ["price", "discount_price","product_id"];
    
    public function product()
    {
    	return $this->belongsTo(Product::class);
    }

    public function getPriceAttribute()
    {
        return $this->attributes["price"] / 100;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes["price"] = $value * 100;
    }

    public function getDiscountPriceAttribute()
    {
        return $this->attributes["discount_price"] / 100;
    }

    public function setDiscountPriceAttribute($value)
    {
        $this->attributes["discount_price"] = $value * 100;
    }
}
