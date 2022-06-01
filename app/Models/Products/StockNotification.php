<?php

namespace App\Models\Products;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class StockNotification extends Model
{

    protected $fillable = ["product_id", "user_id", "email"];


    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
