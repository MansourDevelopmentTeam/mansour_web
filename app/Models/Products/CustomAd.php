<?php

namespace App\Models\Products;

use App\Models\Products\Category;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class CustomAd extends Model
{

	const PRODUCT = 1;
	const SUBCATEGORY = 2;
    const MEDICAL = 3;
	const BRAND = 4;
    const CUSTOM_LIST = 5;
    const CATEGORY = 6;
    const LINK = 7;

    protected $fillable = ["name_en", "name_ar","description_ar", "description_en", "type", "image_en", 'image_ar', "image_web", "image_web_ar", 'active', 'deactivation_notes', 'dev_key','item_id', 'link'];
    protected $hidden = ["product", "sub_category"];
    protected $appends = ["sub_category_id", "product_id", "category_id", "custom_list_id", ];
    protected $casts = [
        'active' => 'integer',
    ];
    // type 1 =  product
    // type 2 =  category
    // type 3 =  medical
    // type 4 =  brand
    // type 5 =  tags
    // type 6 =  custom list
    public static $validations = [
        "type" => "nullable|sometimes",
        "name_en" => "required|string",
        "name_ar" => "required|string",
        "description_ar" => "nullable|string",
        "description_en" => "nullable|string",
        "link" => "nullable|string",
        "image_en" => "required|string",
        "image_ar" => "required|string",
        "image_web" => "required|string",
        "image_web_ar" => "required|string",
        "active" => "sometimes|nullable|in:1,0",
        "dev_key" => "required|string",
        "item_id" => "sometimes|nullable",
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "item_id");
    }
    public function category()
    {
        return $this->belongsTo(Category::class, "item_id");
    }
    public function sub_category()
    {
        return $this->belongsTo(Category::class, "item_id");
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, "item_id");
    }
    public function tags()
    {
        return $this->belongsTo(Tag::class, "item_id");
    }
    public function lists()
    {
        return $this->belongsTo(Lists::class, "item_id");
    }
    public function getName()
    {
        if (request()->header('lang') == 2) {
            return $this->name_ar ?: $this->name_en;
        }
        return $this->name_en;
    }

    public function getDescription()
    {
        if (request()->header('lang') == 2) {
            return $this->description_ar ?: $this->description_en;
        }
        return $this->description_en;
    }

    public function getImage()
    {
        if (request()->header('lang') == 2) {
            return $this->image_ar ?: $this->image_en;
        }
        return $this->image_en;
    }

    public function getImageWeb()
    {
        if (request()->header('lang') == 2) {
            return $this->image_web_ar ?: $this->image_web;
        }
        return $this->image_web;
    }

    public function getImageAttribute()
    {
        if(isset($this->attributes["image"])){
            if(preg_match("/https?:\/\//", $this->attributes["image"])) {
                return $this->attributes["image"];
            }
            return URL::to('') . "/" . $this->attributes["image"];
        }
    }

    public function getCategoryIdAttribute()
    {
        if ($this->type == self::SUBCATEGORY) {
            return $this->sub_category->parent->id;
        } elseif ($this->type == self::CATEGORY) {
            return $this->category->id;
        } elseif ($this->type == self::PRODUCT){
            return $this->product->category->parent->id;
        }
    }

    public function getSubCategoryIdAttribute()
    {
        if ($this->type == self::SUBCATEGORY) {
            return $this->item_id;
        }elseif($this->type == self::PRODUCT){
            return $this->product->category->id;
        }
    }

    public function getNameAttribute()
    {
        if ($this->type == self::SUBCATEGORY) {
            return $this->sub_category->name;
        } elseif ($this->type == self::CATEGORY) {
            return $this->category->name;
        } elseif ($this->type == self::PRODUCT){
            return $this->product->name;
        } else {
            return "None";
        }
    }

    public function getProductIdAttribute()
    {
        if($this->type == self::PRODUCT){
            return $this->item_id;
        }
    }

    public function customList()
    {
        return $this->belongsTo(Lists::class, "item_id");
    }

    public function getCustomListIdAttribute()
    {
        if($this->type == self::CUSTOM_LIST){
            return $this->item_id;
        }
    }

    public function scopeActive($query)
    {
        return $query->where("active", 1);
    }
}
