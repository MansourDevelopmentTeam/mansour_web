<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductBundles extends Model
{
	protected $fillable = ["bundle_id", "product_id"];
    
    public function product()
    {
    	return $this->belongsTo(Product::class,'product_id','id');
    }
    public function bundle()
    {
        return $this->belongsTo(Product::class,'bundle_id','id');
    }

}
