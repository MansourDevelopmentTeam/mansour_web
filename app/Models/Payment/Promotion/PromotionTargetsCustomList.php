<?php

namespace App\Models\Payment\Promotion;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class PromotionTargetsCustomList extends Model
{

    protected $hidden = [
        "target_id",
        "created_at",
        "updated_at",
    ];

    protected $fillable = ['item_id', 'target_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }
}
