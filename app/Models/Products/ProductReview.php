<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ProductReview extends Model
{

    protected $fillable = ["rate", "comment","user_id","product_id","rejection_reason","status","type","order_id"];
    public static $validation = [
        "rate" => "required|numeric",
        "comment" => "required|string",
//        "user_id" => "required|exists:users,id",
        "product_id" => "required|exists:products,id",
        "status" => "sometimes|nullable|in:0,1,2",
    ];



}
