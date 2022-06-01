<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class ProductVariantImage extends Model
{
    protected $hidden =['pivot'];
    protected $fillable = ["name", "path", "size", "type", "product_id","product_variant_id","created_by"];
    public static $validation = [
        "name" => "sometimes|nullable|string",
        "path" =>  "required|string",
        "size" => "sometimes|nullable|string",
        "type" => "sometimes|nullable|string",

        "product_id" => "required|exists:products,id",
        "product_variant_id" => "required|exists:product_variants,id",
        "created_by" => "required|exists:users,id"
    ];
    public function values(){
        return $this->hasMany(OptionValue::class,'option_id','id');
    }


}
