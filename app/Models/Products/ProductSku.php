<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    protected $fillable = ['product_id', 'sku'];
}
