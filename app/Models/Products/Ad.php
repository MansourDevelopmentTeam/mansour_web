<?php

namespace App\Models\Products;

use App\Models\Products\Category;
use App\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Ad extends Model
{

	const PRODUCT = 1;
	const SUBCATEGORY = 2;
    const MEDICAL = 3;
    const BRAND = 4;
    const CUSTOM_LIST = 5;
    const CATEGORY = 6;
    const LINK = 7;

    protected $fillable = ["type", "image","image_ar", "image_web","image_web_ar", "item_id", "order", "popup", 'banner_ad', 'banner_title', 'banner_description', 'banner_title_ar', 'banner_description_ar', 'link'];
    protected $hidden = ["product", "sub_category"];

    protected $appends = ["sub_category_id", "product_id", "category_id", "custom_list_id", "name"];
    protected $casts = [
        'popup' => 'boolean',
        'banner_ad' => 'boolean',
    ];

    // type 1 =  product
    // type 2 =  subcategory
    // type 3 =  medical
    // type 4 =  brand

    //popup bolean
    //banner_ad bolean
    //banner_description string
    public static $validations = [
        "type" => "nullable|sometimes",
        "image" => "sometimes|nullable",
        "item_id" => "required_if:type,1,2",
        "image_ar" => "sometimes|nullable",
        "image_web" => "required",
        "image_web_ar" => "required",
        "order" => "sometimes|nullable|integer",
        "link" => "sometimes|nullable",
        // "popup" => "sometimes|nullable|in:true,false",
        // "banner_ad" => "sometimes|nullable|in:true,false",
        "banner_description" => "sometimes|nullable|string",
        "banner_title" => "sometimes|nullable|string",
        "banner_description_ar" => "sometimes|nullable|string",
        "banner_title_ar" => "sometimes|nullable|string",
    ];
    public function getName()
    {
        if ($this->type == 1) {
            $name = $this->product ? $this->product->getName(app('request')->header('lang')) : "";
        } elseif ($this->type == 2) {
            $name = $this->sub_category ? $this->sub_category->getName(app('request')->header('lang')) : "";
        } elseif ($this->type == 4) {
            $name = $this->brand ? $this->brand->getName(app('request')->header('lang')) : "";
        } elseif ($this->type == 5) {
            $name = $this->customList ? $this->customList->getName(app('request')->header('lang')) : "";
        } else {
            $name = "-";
        }
        return $name;
    }

    public function getImage($lang = 1)
    {
        if ($lang == 2) {
            return $this->image_ar;
        } else {
            return $this->image;
        }
    }

    public function getImageWeb($lang = 1)
    {
        if ($lang == 2) {
            return $this->image_web_ar;
        } else {
            return $this->image_web;
        }
    }
    public function getBannerTitle($lang = 1)
    {
        if ($lang == 2) {
            return $this->banner_title_ar;
        } else {
            return $this->banner_title;
        }
    }
    public function getBannerDescription($lang = 1)
    {
        if ($lang == 2) {
            return $this->banner_description_ar;
        } else {
            return $this->banner_description;
        }
    }
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
            return @$this->sub_category->parent->id;
        } elseif ($this->type == self::CATEGORY) {
            return $this->category->id;
        } elseif ($this->type == self::PRODUCT){
            return @$this->product->category->parent->id;
        }
    }

    public function getSubCategoryIdAttribute()
    {
        if ($this->type == self::SUBCATEGORY) {
            return $this->item_id;
        }elseif($this->type == self::PRODUCT){
            return @$this->product->category->id;
        }
    }

    public function getNameAttribute()
    {
        if ($this->type == self::SUBCATEGORY) {
            return @$this->sub_category->name;
        } elseif ($this->type == self::CATEGORY) {
            return @$this->category->name;
        } elseif ($this->type == self::PRODUCT){
            return @$this->product->name;
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
