<?php

namespace App\Models\Payment\Promotion;

use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class PromotionConditionsCustomList extends Model
{

    protected $hidden = [
        "condition_id",
        "created_at",
        "updated_at",
    ];
    protected $fillable = ['item_id', 'condition_id'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'item_id');
    }
}
