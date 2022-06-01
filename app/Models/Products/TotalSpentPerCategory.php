<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;

class TotalSpentPerCategory extends Model
{
    protected $fillable = ["user_id", "category_id", "total_spent"];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
