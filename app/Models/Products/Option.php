<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Option extends Model
{
    protected $hidden =['pivot'];
    protected $fillable = ["name_en", "name_ar", "description_en", "description_ar", "active","type","appear_in_search", "appear_on_product_details", "created_by", "order"];
    protected $casts = [
        'active' => 'integer',
        'appear_in_search' => 'integer',
    ];
    public static $validation = [
        "name_en" => "required|string",
        "name_ar" => "required|string",
        "description_en" => "sometimes|nullable",
        "description_ar" => "sometimes|nullable",
        "active" => "sometimes|nullable|boolean",
        "appear_in_search" => "sometimes|nullable|boolean",
        "type" => "sometimes|nullable|in:1,2,3,4,5",
    ];
    public function values(){
        return $this->hasMany(OptionValue::class,'option_id','id');
    }
    public function getName($lang = 1)
    {
        if ($lang == 2) {
            return $this->name_ar ?: $this->name_en;
        }
        return $this->name_en;
    }
    public function getDescription($lang = 1)
    {
        if ($lang == 2) {
            return $this->description_ar ?: $this->description_en;
        }
        return $this->description_en;
    }
    public function attributeProducts()
    {
        return $this->belongsToMany(Product::class, ProductOptionValues::class, 'option_id', 'product_id')->where('product_option_values.type','0')->withPivot('product_id','option_id','value_id','type');
    }
    public function ProductValues()
    {
        return $this->hasMany(ProductOptionValues::class, 'option_id');
    }
}
