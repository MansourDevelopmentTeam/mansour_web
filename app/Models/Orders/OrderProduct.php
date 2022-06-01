<?php

namespace App\Models\Orders;

use App\Models\Products\Product;
use App\Models\Products\ProductPrice;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{

    protected $fillable = ["order_id", "product_id", "amount", "price_id", "returned_quantity", "discount_price", "price", "preorder", "preorder_price", "remaining","serial_number", "bundle_id","affiliate_commission"];

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function product()
    {
    	return $this->belongsTo(Product::class)->withTrashed();
    }

    public function bundleProduct()
    {
        return $this->belongsTo(Product::class, "bundle_id");
    }

    public function price()
	{
		return $this->belongsTo(ProductPrice::class);
	}
}
