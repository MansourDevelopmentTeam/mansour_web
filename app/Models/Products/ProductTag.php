<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ProductTag extends Model
{

    protected $fillable = ["tag_id", "product_id"];
    public static $validation = [
        "tag_id" => "required|string",
        "product_id" => "required|string",
    ];

}
